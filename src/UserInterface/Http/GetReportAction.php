<?php

declare(strict_types=1);

namespace App\UserInterface\Http;

use App\Domain\Bonus\Calculator;
use App\Infrastructure\ORM\Entity\VO\Constant;
use App\Infrastructure\ORM\Entity\VO\Percentage;
use Brick\Money\Money;
use Doctrine\DBAL\Connection;
use Dunglas\DoctrineJsonOdm\Serializer;
use Flow\ETL\Adapter\Doctrine\DbalQueryExtractor;
use Flow\ETL\Adapter\Doctrine\ParametersSet;
use Flow\ETL\DSL\Entry;
use Flow\ETL\DSL\Transform;
use Flow\ETL\Flow;
use Flow\ETL\Row;
use Flow\ETL\Row\Sort;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetReportAction
{
    public function __invoke(
        Request $request, Connection $sourceDbConnection, Calculator $calculator, Serializer $serializer
    ): Response {
        $orderDescending = (bool)$request->get('DESC');

        $orderBy = $request->get('orderBy', 'id');

        $extractor = new DbalQueryExtractor(
            $sourceDbConnection,
            'SELECT person.*, department.name as department, department.strategy 
            FROM person
            LEFT JOIN department ON person.department_id = department.id 
            ORDER BY :order_by ' . ($orderDescending ? 'DESC' : 'ASC'),
            new ParametersSet([$orderBy])
        );

        $content = (new Flow())
            ->read($extractor)
            ->rows(Transform::array_unpack('row'))
            ->rows(Transform::string_concat(['name', 'surname'], ' ', 'name'))
            ->sortBy(Sort::desc($orderBy))
            ->transform(Transform::callback_row(
                static function (Row $row) use ($calculator, $serializer): Row {
                    $payout = Money::of($row->get('payout')->value(), 'USD');

                    $strategyVo = $serializer->deserialize($row->get('strategy')->value(), '', 'json');

                    $bonus = $calculator->basedOnSeniority(
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
            ->drop('id', 'department_id', 'row', 'strategy', 'surname')
            ->display();

        return new Response(content: $content);
    }
}