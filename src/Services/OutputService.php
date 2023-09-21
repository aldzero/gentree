<?php

declare(strict_types=1);

namespace App\Services;

class OutputService
{
    private const JSON_OUTPUT_PATH = __DIR__ . '/../../storage/output/output.json';

    private FileService $fileService;

    public function __construct()
    {
        $this->fileService = new FileService();
    }

    public function writeJson(array $data, ?string $path = ''): void
    {
        $json = $this->arrayToJson($data);

        $this->fileService->writeFile($path ?: self::JSON_OUTPUT_PATH, $json);
    }

    public function arrayToJson(array $data): bool|string
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }


}