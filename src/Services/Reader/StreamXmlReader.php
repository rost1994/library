<?php declare(strict_types=1);

namespace BookLibrary\Services\Reader;

use BookLibrary\Entity\Record;
use BookLibrary\Entity\RecordInterface;
use InvalidArgumentException;
use SimpleXMLElement;
use function sprintf;
use XMLReader;

class StreamXmlReader implements StreamReaderInterface
{
    private const XML_TEXT_ELEMENT = '#text';

    /** @var XMLReader */
    private $reader;

    public function __construct(string $filePath)
    {
        $this->reader = new XMLReader;

        if (!$this->reader->open($filePath)) {
            throw new InvalidArgumentException(sprintf('Unable to open file %s', $filePath));
        }

        // Move pointer to record elements
        $this->reader->read();
        $this->reader->read();
    }

    public function read(): RecordInterface
    {
        $this->readLineBreak();

        $xmlRecord = new SimpleXMLElement($this->reader->readOuterXml());

        $person = (string) $xmlRecord->person['id'];
        $isbn = (string) $xmlRecord->isbn;
        $date = (string) $xmlRecord->timestamp;
        $type = (string) $xmlRecord->action['type'];

        $this->reader->next();

        return new Record($person, $isbn, $date, $type);
    }

    public function finished(): bool
    {
        $this->readLineBreak();

        return $this->reader->name !== 'record';
    }

    public function __destruct()
    {
        $this->reader->close();
    }

    private function readLineBreak(): void
    {
        if ($this->reader->name === self::XML_TEXT_ELEMENT) {
            $this->reader->read();
        }
    }
}
