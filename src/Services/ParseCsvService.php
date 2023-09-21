<?php

declare(strict_types=1);

namespace App\Services;

use App\Schemas\TreeItemSchema;
use Exception;

// TODO Вынести логику не связаную с CSV (метод parse)
class ParseCsvService
{
    private const ITEM_NAME_FIELD_IDX = 0;
    private const TYPE_FIELD_IDX = 1;
    private const PARENT_FIELD_IDX = 2;
    private const RELATION_FIELD_IDX = 3;
    private const CSV_INPUT_PATH = 'storage/input/input.csv';
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
    public function parse(): ?array
    {
        $path = $this->checkFileExistence();
        $this->fileService->readFile($path);

        $this->checkHeaders();

        $result = $this->groupItemsByParent();

        $this->fileService->closeFile();

        return $result;
    }

    /**
     * @throws Exception
     */
    private function groupItemsByParent(): array
    {
        $csvItem = $this->fileService->nextCsvString();
        $groupItems = [];

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
    private function checkFileExistence()
    {
        return realpath(self::CSV_INPUT_PATH)
            ?: throw new Exception('CSV файл не найден в директории "storage/input".');
    }

    /**
     * @throws Exception
     */
    private function checkHeaders(): void
    {
        $headers = $this->fileService->nextCsvString();

        foreach ($headers as $key => $header) {
            if ($header !== self::HEADERS[$key]) {
                throw new Exception('Заголовки не соотвествуют стандарту, проверьте файл');
            }
        }
    }
}