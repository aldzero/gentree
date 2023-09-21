<?php

use App\Services\FileService;
use PHPUnit\Framework\TestCase;

class GentreeTest extends TestCase
{
    private array $fixture;

    protected function setUp(): void
    {
        $json = file_get_contents(__DIR__ . '/fixtures/output.json');

        if ($json === false) {
            throw new Error('Ошибка.Фикстура output.json в директории "fixtures" не найдена');
        }

        $this->fixture = json_decode($json, true);
    }

    public function testResult()
    {

        $result = json_decode(file_get_contents(__DIR__ . '/fixtures/result.json'), true);


        $this->assertEquals($this->fixture, $result);
    }
}