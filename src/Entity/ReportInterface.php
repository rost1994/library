<?php declare(strict_types=1);

namespace BookLibrary\Entity;

interface ReportInterface
{
    public function __construct(
        string $mostCheckoutPerson,
        string $mostCheckedOutBook,
        int $checkoutsCount,
        string $mostBooksPerson
    );

    public function getMostCheckoutPerson(): string;

    public function getMostCheckedOutBook(): string;

    public function getCheckoutsCount(): int;

    public function getMostBooksPerson(): string;
}
