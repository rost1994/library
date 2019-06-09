<?php declare(strict_types=1);

namespace BookLibrary;

use BookLibrary\Entity\ReportInterface;
use BookLibrary\Services\Builder\ReportBuilder;
use BookLibrary\Services\Factory\OutputFactory;
use BookLibrary\Services\Factory\ReaderFactory;
use BookLibrary\Services\Reporter;
use function fclose;
use function fopen;
use function fwrite;

class Application
{
    /** @var string[] */
    private $transactionsFilePaths;

    /** @var Reporter */
    private $reporter;

    /** @var ReportInterface */
    private $report;

    /** @var ReaderFactory */
    private $readerFactory;

    /** @var OutputFactory */
    private $outputFactory;

    public function __construct(array $transactionsFilePaths)
    {
        $this->boot();

        $this->transactionsFilePaths = $transactionsFilePaths;
    }

    public function run(): self
    {
        foreach ($this->transactionsFilePaths as $path) {
            $this->handleTransactionLog($path);
        }

        $this->report = $this->reporter->getReport();

        return $this;
    }

    public function report(string $outputPath): self
    {
        $output = $this->outputFactory->getOutputForFile($outputPath);

        $outputFile = fopen($outputPath, 'wb');

        fwrite($outputFile, $output->print($this->report));

        fclose($outputFile);

        return $this;
    }

    private function handleTransactionLog(string $filePath): void
    {
        $reader = $this->readerFactory->getReaderForFile($filePath);

        while (!$reader->finished()) {
            $this->reporter->addRecord($reader->read());
        }
    }

    private function boot(): void
    {
        $this->reporter = new Reporter(new ReportBuilder());

        $this->outputFactory = new OutputFactory();

        $this->readerFactory = new ReaderFactory();
    }
}
