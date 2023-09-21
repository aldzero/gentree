<?php

declare(strict_types=1);

namespace App\Services;

use App\Schemas\TreeItemSchema;
use Exception;

class InputService
{
    private const ITEM_NAME_FIELD_IDX = 0;
    private const PARENT_FIELD_IDX = 2;
    private const RELATION_FIELD_IDX = 3;
    private const CSV_INPUT_PATH = __DIR__ . '/../../storage/input/input.csv';
    private const HEADERS = [
        'Item Name',
        'Type',
        'Parent',
        'Relation'
    ];

    private FileService $fileService;

    public function __construct()
    {
        $this->fileService = new FileService();
    }

    /**
     * @throws Exception
     */
    public function parse(?string $path = ''): ?array
    {
        $this->readCsv($path);
        $this->checkHeaders();
        $result = $this->groupItemsByParent();

        $this->fileService->closeFile();

        return $result;
    }

    /**
     * @throws Exception
     */
    private function readCsv(?string $path): void
    {
        $this->fileService->readFile($path ?: self::CSV_INPUT_PATH);
    }

    /**
     * @throws Exception
     */
    private function groupItemsByParent(): array
    {
        $groupItems = [];

        $csvItem = $this->fileService->nextCsvString();

        while ($csvItem !== false) {
            $itemName = $csvItem[self::ITEM_NAME_FIELD_IDX];
            $parent = $csvItem[self::PARENT_FIELD_IDX];
            $relation = $csvItem[self::RELATION_FIELD_IDX];

            $treeItem = new TreeItemSchema($itemName, $parent ?: null, $relation);
            $groupItems[$parent][] = $treeItem;

            $csvItem = $this->fileService->nextCsvString();
        }

        return $groupItems;
    }

    /**
     * @throws Exception
     */
    private function checkHeaders(): void
    {
        $headers = $this->fileService->nextCsvString();

        foreach (self::HEADERS as $key => $header) {
            if (!isset($headers[$key]) || $header !== $headers[$key]) {
                throw new Exception(
                    'Заголовки не соотвествуют стандарту, проверьте csv файл в директории "storage/input"'
                );
            }
        }
    }
}