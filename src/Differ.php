<?php

namespace Differ\Differ;

use function Differ\Builder\build;
use function Differ\Reader\getContent;
use function Differ\Parser\parse;
use function Differ\Reader\getFileFormat;
use function Differ\Formatters\render;

/**
 * @param string $firstFilePath
 * @param string $secondFilePath
 * @param string $format
 * @return string
 * @throws \Exception
 */
function genDiff(string $firstFilePath, string $secondFilePath, string $format = 'stylish'): string
{
    $firstFileContent = getContent($firstFilePath);
    $secondFileContent = getContent($secondFilePath);

    $firstData = parse($firstFileContent, getFileFormat($firstFilePath));
    $secondData = parse($secondFileContent, getFileFormat($secondFilePath));

    $tree = build($firstData, $secondData);

    return render($tree, $format);
}
