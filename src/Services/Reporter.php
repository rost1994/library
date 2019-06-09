<?php declare(strict_types=1);

namespace BookLibrary\Services;

use function array_filter;
use BookLibrary\Entity\RecordInterface;
use BookLibrary\Entity\ReportInterface;
use BookLibrary\Services\Builder\ReportBuilder;
use DateTimeImmutable;

class Reporter
{
    /** @var array[string]int */
    private $personsCheckouts;

    /** @var DateTimeImmutable[] */
    private $bookCheckoutTimestamps;

    /** @var array[string]int */
    private $bookCheckoutDurations;

    /** @var int */
    private $currentBooksCheckouts;

    /** @var array[string]int */
    private $currentPersonsCheckouts;

    /** @var ReportBuilder */
    private $reportBuilder;

    public function __construct(ReportBuilder $reportBuilder)
    {
        $this->reportBuilder = $reportBuilder;
    }

    public function addRecord(RecordInterface $record): self
    {
        $this->updatePersonsCheckouts($record);
        $this->updateBookDuration($record);
        $this->updateTotalBooksCheckouts($record);
        $this->updateCurrentPersonsCheckouts($record);

        return $this;
    }

    public function getReport(): ReportInterface
    {
        // Update check-out time for all books without check-in
        $this->bookCheckoutTimestamps = array_filter($this->bookCheckoutTimestamps);

        foreach ($this->bookCheckoutTimestamps as $book => $bookCheckoutTimestamp) {
            $this->updateBookCheckinTime($book, new DateTimeImmutable);
        }

        return $this->reportBuilder
            ->withPersonsCheckouts($this->personsCheckouts)
            ->withBookCheckoutDurations($this->bookCheckoutDurations)
            ->withCurrentBooksCheckouts($this->currentBooksCheckouts)
            ->withCurrentPersonsCheckouts($this->currentPersonsCheckouts)
            ->build();
    }

    private function updatePersonsCheckouts(RecordInterface $record): void
    {
        if ($record->getType() !== RecordInterface::CHECKOUT_TYPE) {
            return;
        }

        $personCheckouts = $this->personsCheckouts[$record->getPersonId()] ?? 0;

        $this->personsCheckouts[$record->getPersonId()] = ++$personCheckouts;
    }

    private function updateBookDuration(RecordInterface $record): void
    {
        if ($record->getType() === RecordInterface::CHECKOUT_TYPE) {
            $this->bookCheckoutTimestamps[$record->getIsbn()] = $record->getDate();
        } elseif ($record->getType() === RecordInterface::CHECKIN_TYPE) {
            $this->updateBookCheckinTime($record->getIsbn(), $record->getDate());
        }
    }

    private function updateBookCheckinTime(string $book, DateTimeImmutable $checkinDate): void
    {
        $bookCheckoutTimestamp = $this->bookCheckoutTimestamps[$book];
        $bookCheckoutTimeRange = $this->bookCheckoutDurations[$book] ?? 0;

        $bookLastCheckoutTime = $checkinDate->diff($bookCheckoutTimestamp, true)->d;

        $this->bookCheckoutDurations[$book] = $bookCheckoutTimeRange + $bookLastCheckoutTime;
        unset($this->bookCheckoutTimestamps[$book]);
    }

    private function updateTotalBooksCheckouts(RecordInterface $record): void
    {
        if ($record->getType() === RecordInterface::CHECKOUT_TYPE) {
            ++$this->currentBooksCheckouts;
        } elseif ($record->getType() === RecordInterface::CHECKIN_TYPE) {
            --$this->currentBooksCheckouts;
        }
    }

    private function updateCurrentPersonsCheckouts(RecordInterface $record): void
    {
        $currentPersonCheckouts = $this->currentPersonsCheckouts[$record->getPersonId()] ?? 0;

        if ($record->getType() === RecordInterface::CHECKOUT_TYPE) {
            $this->currentPersonsCheckouts[$record->getPersonId()] = ++$currentPersonCheckouts;
        } elseif ($record->getType() === RecordInterface::CHECKIN_TYPE) {
            $this->currentPersonsCheckouts[$record->getPersonId()] = --$currentPersonCheckouts;
        }
    }
}
