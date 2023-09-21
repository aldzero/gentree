<?php

declare(strict_types=1);

use App\Application;
use App\Services\InputService;
use App\Services\OutputService;
use App\Services\TreeService;
use PHPUnit\Framework\TestCase;

class GentreeTest extends TestCase
{
    private const INPUT_FIXTURE_PATH = __DIR__ . '/fixtures/input.csv';
    private const TEST_OUTPUT_PATH = __DIR__ . '/../../storage/tests/output.json';
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
    public function testCompareFiles()
    {
        $app = new Application(self::INPUT_FIXTURE_PATH, self::TEST_OUTPUT_PATH);
        $app();

        $actual = file_get_contents(__DIR__ . '/../../storage/tests/output.json');

        $result = json_decode($actual, true);
        $this->assertEquals($this->fixture, $result);
    }
}