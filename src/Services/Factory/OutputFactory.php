<?php declare(strict_types=1);

namespace BookLibrary\Services\Factory;

use BookLibrary\Services\Helpers\FileHelper;
use BookLibrary\Services\Output\FileOutputInterface;
use BookLibrary\Services\Output\JsonOutput;
use BookLibrary\Services\Output\TextOutput;
use OutOfBoundsException;
use function sprintf;

class OutputFactory
{
    private const OUTPUT_EXTENSION_DICTIONARY = [
        'json' => JsonOutput::class,
        'txt' => TextOutput::class
    ];

    /** @var string[] */
    private $outputExtensionDictionary;

    public function __construct(array $outputExtensionDictionary = self::OUTPUT_EXTENSION_DICTIONARY)
    {
        $this->outputExtensionDictionary = $outputExtensionDictionary;
    }

    public function getOutputForFile(string $filePath): FileOutputInterface
    {
        $extension = FileHelper::getExtension($filePath);

        $readerClass = $this->outputExtensionDictionary[$extension];

        if (empty($readerClass)) {
            throw new OutOfBoundsException(sprintf('No valid output for specified file %s', $filePath));
        }

        return new $readerClass($filePath);
    }
}
