<?php

declare(strict_types=1);

namespace App;

use App\Services\FileService;
use App\Services\ParseCsvService;
use App\Services\TreeService;
use Exception;

class Application
{
    /**
     * @throws Exception
     */
    public function __invoke(): void
    {
        $csvService = new ParseCsvService();
        $items = $csvService->parse();

        $treeService = new TreeService($items);
        $result = $treeService->build();

        $fileService = new FileService();
        $fileService->writeFile($result);
    }
}