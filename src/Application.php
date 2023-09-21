<?php

declare(strict_types=1);

namespace App;

use App\Services\InputService;
use App\Services\OutputService;
use App\Services\TreeService;
use Exception;

class Application
{
    /**
     * @throws Exception
     */
    public function __invoke(): void
    {
        $csvService = new InputService();
        $items = $csvService->parse();

        $treeService = new TreeService($items);
        $result = $treeService->build();

        $output = new OutputService();
        $output->writeJson($result);
    }
}