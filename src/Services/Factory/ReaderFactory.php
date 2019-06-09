<?php declare(strict_types=1);

namespace BookLibrary\Services\Factory;

use BookLibrary\Services\Helpers\FileHelper;
use BookLibrary\Services\Reader\StreamCsvReader;
use BookLibrary\Services\Reader\StreamReaderInterface;
use BookLibrary\Services\Reader\StreamXmlReader;
use OutOfBoundsException;
use function sprintf;

class ReaderFactory
{
    private const READER_EXTENSION_DICTIONARY = [
        'xml' => StreamXmlReader::class,
        'csv' => StreamCsvReader::class,
    ];

    /** @var string[] */
    private $readerExtensionDictionary;

    public function __construct(array $readerExtensionDictionary = self::READER_EXTENSION_DICTIONARY)
    {
        $this->readerExtensionDictionary = $readerExtensionDictionary;
    }

    public function getReaderForFile(string $filePath): StreamReaderInterface
    {
        $extension = FileHelper::getExtension($filePath);

        $readerClass = $this->readerExtensionDictionary[$extension];

        if (empty($readerClass)) {
            throw new OutOfBoundsException(sprintf('No valid readers for specified file %s', $filePath));
        }

        return new $readerClass($filePath);
    }
}
