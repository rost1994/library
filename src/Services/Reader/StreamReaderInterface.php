<?php declare(strict_types=1);

namespace BookLibrary\Services\Reader;

use BookLibrary\Entity\RecordInterface;

interface StreamReaderInterface
{
    public function __construct(string $filePath);

    public function read(): RecordInterface;

    public function finished(): bool;
}
