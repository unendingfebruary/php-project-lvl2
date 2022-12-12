<?php

namespace Differ\Tests;

use Exception;
use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    private string $fixturesPath = 'tests/fixtures/';

    /**
     * @dataProvider dataProvider
     * @param $file1
     * @param $file2
     * @param $result
     * @param $format
     * @return void
     * @throws Exception
     */
    public function testGenDiff($file1, $file2, $result, $format): void
    {
        $pathToFile1 = $this->fixturesPath . $file1;
        $pathToFile2 = $this->fixturesPath . $file2;
        $expected = file_get_contents($this->fixturesPath . $result);
        $actual = genDiff($pathToFile1, $pathToFile2, $format);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return string[][]
     */
    public function dataProvider(): array
    {
        return [
            ['file1.json', 'file2.json', 'result.txt', 'stylish'],
            ['file1.yaml', 'file2.yaml', 'result.txt', 'stylish'],
        ];
    }
}
