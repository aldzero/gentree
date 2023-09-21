<?php

declare(strict_types=1);

use App\Application;
use PHPUnit\Framework\TestCase;

class GentreeTest extends TestCase
{
    private array $fixture;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $json = file_get_contents(__DIR__ . '/fixtures/output.json');

        if ($json === false) {
            throw new Exception('Ошибка.Фикстура output.json в директории "fixtures" не найдена');
        }

        $this->fixture = json_decode($json, true);
    }

    /**
     * @throws Exception
     */
    public function testResult()
    {
        $app = new Application();
        $app();

        $actual = file_get_contents(__DIR__ . '/../../storage/output/output.json');
        $result = json_decode($actual, true);
        $this->assertEquals($this->fixture, $result);
    }
}