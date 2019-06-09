<?php declare(strict_types=1);

namespace BookLibrary\Entity;

use DateTime;
use DateTimeImmutable;

interface RecordInterface
{
    public const CHECKOUT_TYPE = 'check-out';
    public const CHECKIN_TYPE = 'check-in';
    public const DATE_TIME_FORMAT = DateTime::W3C;

    public function getPersonId(): string;

    public function getIsbn(): string;

    public function getDate(): DateTimeImmutable;

    public function getType(): string;
}
