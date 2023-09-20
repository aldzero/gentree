<?php

declare(strict_types=1);

namespace App;

use App\Services\ParseCsvService;
use Exception;

class Application
{
    public function __invoke(): void
    {
        $csvService = new ParseCsvService();
        try {
            $items = $csvService->parse();

        } catch (Exception $exception) {
            print($exception->getMessage());
        }
    }
}