<?php declare(strict_types=1);

namespace BookLibrary\Services\Builder;

use BookLibrary\Entity\Report;
use BookLibrary\Entity\ReportInterface;
use BookLibrary\Services\Helpers\ReporterHelper;

class ReportBuilder
{
    /** @var string */
    private $mostCheckoutPerson;

    /** string */
    private $mostCheckedOutBook;

    /** @var int */
    private $checkoutsCount;

    /** @var string */
    private $mostBooksPerson;

    public function withPersonsCheckouts(array $personsCheckouts): self
    {
        $this->mostCheckoutPerson = ReporterHelper::getMaxIndex($personsCheckouts);

        return $this;
    }

    public function withBookCheckoutDurations(array $bookCheckoutDurations): self
    {
        $this->mostCheckedOutBook = ReporterHelper::getMaxIndex($bookCheckoutDurations);

        return $this;
    }
    
    public function withCurrentBooksCheckouts(int $currentBooksCheckouts): self
    {
        $this->checkoutsCount = $currentBooksCheckouts;

        return $this;
    }
    
    public function withCurrentPersonsCheckouts(array $currentPersonsCheckouts): self
    {
        $this->mostBooksPerson = ReporterHelper::getMaxIndex($currentPersonsCheckouts);

        return $this;
    }

    public function build(): ReportInterface
    {
        return new Report(
            $this->mostCheckoutPerson,
            $this->mostCheckedOutBook,
            $this->checkoutsCount,
            $this->mostBooksPerson
        );
    }
}
