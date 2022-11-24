<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    private string $fixturesPath = 'tests/fixtures/';

    /**
     * @return void
     * @throws \Exception
     */
    public function testGenDiff(): void
    {
        $pathToFile1 = $this->fixturesPath . 'file1.json';
        $pathToFile2 = $this->fixturesPath . 'file2.json';
        $expected = file_get_contents($this->fixturesPath . 'result.txt');
        $actual = genDiff($pathToFile1, $pathToFile2);

        $this->assertEquals($expected, $actual);
    }
}
