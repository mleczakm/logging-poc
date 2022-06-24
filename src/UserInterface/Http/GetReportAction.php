<?php

declare(strict_types=1);

namespace App\UserInterface\Http;

use App\Application\Query\Report;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetReportAction
{
    public function __invoke(Request $request, Report $report): Response {
        $orderBy = $request->get('orderBy', 'id');

        if (!in_array($orderBy, ['id', 'name', 'surname', 'payout'])) {
            return new Response(status: Response::HTTP_BAD_REQUEST);
        }

        return new Response(content: $report->monthly($orderBy));
    }
}