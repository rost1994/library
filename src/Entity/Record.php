<?php declare(strict_types=1);

namespace BookLibrary\Entity;

use DateTimeImmutable;

class Record implements RecordInterface
{
    /** @var string */
    private $personId;

    /** @var string */
    private $isbn;

    /** @var DateTimeImmutable */
    private $date;

    /** @var string */
    private $type;

     public function __construct(string $personId, string $isbn, string $date, string $type)
    {
        $this->personId = $personId;
        $this->isbn     = $isbn;
        $this->date     = DateTimeImmutable::createFromFormat(RecordInterface::DATE_TIME_FORMAT, $date);
        $this->type     = $type;
    }

    public function getPersonId(): string
    {
        return $this->personId;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
