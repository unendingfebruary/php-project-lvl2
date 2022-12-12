<?php

namespace Differ\Differ;

use function Differ\Builder\build;
use function Differ\Reader\getContent;
use function Differ\Parser\parse;
use function Differ\Reader\getFileFormat;
use function Differ\Formatters\render;

/**
 * @param $firstFilePath
 * @param $secondFilePath
 * @param $format
 * @return string
 * @throws \Exception
 */
function genDiff($firstFilePath, $secondFilePath, $format): string
{
    $firstFileContent = getContent($firstFilePath);
    $secondFileContent = getContent($secondFilePath);

    $firstData = parse($firstFileContent, getFileFormat($firstFilePath));
    $secondData = parse($secondFileContent, getFileFormat($secondFilePath));

    $tree = build($firstData, $secondData);

    return render($tree, $format) . PHP_EOL;
}
