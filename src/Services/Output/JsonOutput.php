<?php declare(strict_types=1);

namespace BookLibrary\Services\Output;

use BookLibrary\Entity\ReportInterface;
use function json_encode;
use const JSON_PRETTY_PRINT;

class JsonOutput implements FileOutputInterface
{
    public function print(ReportInterface $report): string
    {
        return json_encode([
            'person' => [
                'most_checkouts_total'   => $report->getMostCheckoutPerson(),
                'most_checkouts_current' => $report->getMostBooksPerson(),
            ],
            'book'   => [
                'longest_checkout_duration' => $report->getMostCheckedOutBook(),
                'current_checkouts_count'   => $report->getCheckoutsCount(),
            ]
        ], JSON_PRETTY_PRINT);
    }
}
