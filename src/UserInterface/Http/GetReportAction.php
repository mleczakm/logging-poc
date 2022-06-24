<?php

declare(strict_types=1);

namespace App\UserInterface\Http;

use App\Application\Query\Report;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetReportAction
{
    public function __invoke(Request $request, Report $report): Response
    {
        $orderBy = $request->get('orderBy', 'id');

        $supportedColumns = ['id', 'name', 'surname', 'payout', 'department'];

        if (! in_array($orderBy, ['id', 'name', 'surname', 'payout', 'department'])) {
            return new Response(status: Response::HTTP_BAD_REQUEST);
        }

        $filterOut = $request->get('filterOut', []);

        if (! is_array($filterOut) || array_diff(array_keys($filterOut), $supportedColumns) !== []) {
            return new Response(status: Response::HTTP_BAD_REQUEST);
        }

        return new Response(content: $report->monthly($orderBy, $filterOut));
    }
}