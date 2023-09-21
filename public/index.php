<?php

declare(strict_types=1);

use App\Application;

require_once __DIR__ . '/../vendor/autoload.php';

$application = new Application;

try {
    $application();
} catch (Exception $exception) {
    print($exception->getMessage());
}