<?php declare(strict_types=1);

namespace BookLibrary\Services\Reader;

use function array_combine;
use BookLibrary\Entity\Record;
use BookLibrary\Entity\RecordInterface;
use function fclose;
use function feof;
use function fgets;
use InvalidArgumentException;
use function str_getcsv;

class StreamCsvReader implements StreamReaderInterface
{
    private const RECORD_TIMESTAMP = 'timestamp';
    private const RECORD_PERSON = 'person';
    private const RECORD_ISBN = 'isbn';
    private const RECORD_ACTION = 'action';

    private $stream;

    private $head = [];

    public function __construct(string $filePath)
    {
        $this->stream = fopen($filePath, 'rb');

        if (!$this->stream) {
            throw new InvalidArgumentException(sprintf('Unable to open file %s', $filePath));
        }

        $this->head = $this->readCsvLine();
    }

    public function read(): RecordInterface
    {
        $xmlRecord = array_combine($this->head, $this->readCsvLine());

        return new Record(
            $xmlRecord[static::RECORD_PERSON],
            $xmlRecord[static::RECORD_ISBN],
            $xmlRecord[static::RECORD_TIMESTAMP],
            $xmlRecord[static::RECORD_ACTION]
        );
    }

    public function finished(): bool
    {
        return feof($this->stream);
    }

    public function __destruct()
    {
        fclose($this->stream);
    }

    private function readCsvLine(): array
    {
        return str_getcsv(fgets($this->stream));
    }
}
