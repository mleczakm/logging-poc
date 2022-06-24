<?php

declare(strict_types=1);

namespace App\Infrastructure\ETL;

use App\Domain\Bonus\Calculator;
use App\Infrastructure\ORM\Entity\VO\Constant;
use App\Infrastructure\ORM\Entity\VO\Percentage;
use Brick\Money\Money;
use Doctrine\DBAL\Connection;
use Dunglas\DoctrineJsonOdm\Serializer;
use Flow\ETL\Adapter\Doctrine\DbalQueryExtractor;
use Flow\ETL\DSL\Entry;
use Flow\ETL\DSL\Transform;
use Flow\ETL\Flow;
use Flow\ETL\Formatter\AsciiTableFormatter;
use Flow\ETL\Row;
use Flow\ETL\Row\Sort;

final class Report implements \App\Application\Query\Report
{
    public function __construct(
        private readonly Connection $connection,
        private readonly Calculator $calculator,
        private readonly Serializer $serializer,
    )
    {
    }

    public function monthly(string $orderBy)
    {


        $extractor = new DbalQueryExtractor(
            $this->connection,
            'SELECT person.*, department.name as department, department.strategy 
            FROM person
            LEFT JOIN department ON person.department_id = department.id'
        );

        return (new Flow())
            ->read($extractor)
            ->rows(Transform::array_unpack('row'))
            ->rows(Transform::string_concat(['name', 'surname'], ' ', 'name'))
            ->sortBy(Sort::desc($orderBy))
            ->transform(Transform::callback_row(
                function (Row $row): Row {
                    $payout = Money::of($row->get('payout')->value(), 'USD');

                    $strategyVo = $this->serializer->deserialize($row->get('strategy')->value(), '', 'json');

                    $bonus = $this->calculator->basedOnSeniority(
                        $row->get('seniority')->value(),
                        $payout,
                        match (get_class($strategyVo)) {
                            Constant::class => new \App\Domain\Constant($strategyVo->amount),
                            Percentage::class => new \App\Domain\Percentage($strategyVo->percentage),
                        }
                    );

                    return $row->add(Entry::string(
                        'bonus',
                        $bonus->formatTo('pl_PL')
                    ))
                        ->remove('payout')
                        ->add(Entry::string('payout', $payout->formatTo('pl_PL')))
                        ->add(Entry::string('full payout', $payout->plus($bonus)->formatTo('pl_PL')));
                }
            ))
            ->sortBy(Sort::asc($orderBy))
            ->drop('id', 'department_id', 'row', 'strategy', 'surname')
            ->display(formatter: new AsciiTableFormatter())
            ;
    }
}