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
    private const RELATION = 3;
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

        $result = $this->groupItemsByParent();

        $this->closeFile();

        return $result;
    }

    private function groupItemsByParent(): array
    {
        $csvItem = $this->next(); //TODO сделать проверку хедеров
        $csvItem = $this->next();
        $groupItems = [];

        while ($csvItem !== false) {
            $itemName = $csvItem[self::ITEM_NAME_FIELD_IDX];
            $parent = $csvItem[self::PARENT_FIELD_IDX];
            $relation = $csvItem[self::RELATION];
            $treeItem = new TreeItemSchema($itemName, $parent, $relation);

            $groupItems[$parent][] = $treeItem;

            $csvItem = $this->next();
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