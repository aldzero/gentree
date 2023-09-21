<?php

declare(strict_types=1);

namespace App\Services;

class FileService
{
    public function writeFile($data): void
    {
        $file = fopen(realpath('storage/output') . '/output.json', 'w');
        fwrite($file, json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT));
        fclose($file);
    }
}