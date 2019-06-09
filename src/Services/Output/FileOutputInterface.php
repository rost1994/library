<?php declare(strict_types=1);

namespace BookLibrary\Services\Output;

use BookLibrary\Entity\ReportInterface;

interface FileOutputInterface
{
    public function print(ReportInterface $report): string;
}
