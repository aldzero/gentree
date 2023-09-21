<?php

declare(strict_types=1);

namespace App;

use App\Services\InputService;
use App\Services\OutputService;
use App\Services\TreeService;
use Exception;

class Application
{
    public function __construct(
        private readonly ?string $inputPath = '',
        private readonly ?string $outputPath = ''
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(): void
    {
        $csvService = new InputService();
        $items = $csvService->parse($this->inputPath);

        $treeService = new TreeService($items);
        $result = $treeService->build();

        $output = new OutputService();
        $output->writeJson($result, $this->outputPath);
    }
}