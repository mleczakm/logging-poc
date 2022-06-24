<?php

declare(strict_types=1);

namespace App\UserInterface\Http;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class AddUserAction
{
    public function __construct(private readonly Connection $connection)
    {

    }

    public function __invoke(Request $request)
    {
        $data = $request->request;

        $stmt = $this->connection->prepare(<<<SQL
                INSERT INTO customer (id, department_id, name, surname, payout, seniority)
                VALUES (:id, :department_id, :name, :surname, :payout, :seniority)
            SQL
        );
        $stmt->bindValue(':id', $data->get('id'), 'ulid');
        $stmt->bindValue(':department_id', $data->get('department_id'), 'ulid');
        $stmt->bindValue(':name', $data->get('name'));
        $stmt->bindValue(':surname', $data->get('surname'));
        $stmt->bindValue(':payout', $data->get('payout'), 'decimal');
        $stmt->bindValue(':seniority', $data->get('payout'));

        $stmt->execute();

        return new Response(status: 204);

    }
}