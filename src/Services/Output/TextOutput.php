<?php declare(strict_types=1);

namespace BookLibrary\Services\Output;

use BookLibrary\Entity\ReportInterface;
use const PHP_EOL;
use function sprintf;

class TextOutput implements FileOutputInterface
{
    public function print(ReportInterface $report): string
    {
        $output = '';

        $output .= $this->printBlock(
            sprintf(
                'Which person has the most checkouts (which person_id): %s',
                $report->getMostCheckoutPerson()
            )
        );
        $output .= $this->printBlock(
            sprintf(
                'Which book was checked out the longest time in total (summed up over all transactions): %s',
                $report->getMostCheckedOutBook()
            )
        );
        $output .= $this->printBlock(
            sprintf('How many books are checked out at this moment: %s', $report->getCheckoutsCount())
        );
        $output .= $this->printBlock(
            sprintf('Who currently has the largest number of books: %s', $report->getMostBooksPerson())
        );

        return $output;
    }

    private function printBlock(string $text): string
    {
        return $text . PHP_EOL . PHP_EOL;
    }
}
