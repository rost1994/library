<?php declare(strict_types=1);

namespace BookLibrary\Entity;

class Report implements ReportInterface
{
    /** @var string */
    private $mostCheckoutPerson;

    /** @var string */
    private $mostCheckedOutBook;

    /** @var int */
    private $checkoutsCount;

    /** @var string */
    private $mostBooksPerson;

    public function __construct(
        string $mostCheckoutPerson,
        string $mostCheckedOutBook,
        int $checkoutsCount,
        string $mostBooksPerson
    ) {
        $this->mostCheckoutPerson = $mostCheckoutPerson;
        $this->mostCheckedOutBook = $mostCheckedOutBook;
        $this->checkoutsCount     = $checkoutsCount;
        $this->mostBooksPerson    = $mostBooksPerson;
    }

    public function getMostCheckoutPerson(): string
    {
        return $this->mostCheckoutPerson;
    }

    public function getMostCheckedOutBook(): string
    {
        return $this->mostCheckedOutBook;
    }

    public function getCheckoutsCount(): int
    {
        return $this->checkoutsCount;
    }

    public function getMostBooksPerson(): string
    {
        return $this->mostBooksPerson;
    }
}
