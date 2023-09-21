<?php

declare(strict_types=1);

use App\Application;

require_once realpath('vendor/autoload.php');


$application = new Application;

try {
    $application();
} catch (Exception $exception) {
    print($exception->getMessage());
}