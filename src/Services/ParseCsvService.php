<?php

declare(strict_types=1);

namespace App\Services;

use Exception;

class ParseCsvService
{
    private const CSV_INPUT_PATH = 'storage/input/input.csv';

    /** @var resource */
    private $resource;

    /**
     * @throws Exception
     */
    public function parse(): ?array
    {
        $path = $this->checkFileExistence();
        $this->openFile($path);

        $csvString = $this->next();

        $result = [];

        while (!empty($csvString)) {
            $csvString = $this->next();
            $result[] = $csvString;
        }

        $this->closeFile();

        return $result;
    }

    /**
     * @throws Exception
     */
    private function checkFileExistence()
    {
        return realpath(self::CSV_INPUT_PATH)
            ?: throw new Exception('CSV файл не найден в директории "storage/input".');
    }

    /**
     * @param string $path
     */
    private function openFile(string $path): void
    {
        $this->resource = fopen($path, "r");
    }

    private function closeFile(): void
    {
        fclose($this->resource);
    }

    private function next(): bool|array
    {
        return fgetcsv($this->resource, null, ';');
    }
}