<?php

declare(strict_types=1);

namespace App\Services;

use Exception;

class FileService
{
    /** @var resource|false */
    private $resource;

    /**
     * @throws Exception
     */
    public function readFile(string $path): void
    {
        $this->closeFile();

        $this->resource = fopen($path, "r") ?: throw new Exception("Файл \"{$path} не найден");
    }

    public function writeFile(string $path, string $data): void
    {
        $this->closeFile();

        $file = fopen($path, 'w');
        fwrite($file, $data);
    }

    public function closeFile(): void
    {
        if ($this->resource !== null) {
            fclose($this->resource);
        }
    }

    /**
     * @throws Exception
     */
    public function nextCsvString(): bool|array
    {
        if ($this->resource === false) {
            throw new Exception('Файл не открыт для чтения');
        }

        return fgetcsv($this->resource, null, ';');
    }
}