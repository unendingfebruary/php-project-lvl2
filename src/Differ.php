<?php

namespace Differ\Differ;

use function Differ\Reader\getContent;
use function Differ\Parser\parse;
use function Differ\Reader\getFileFormat;

const LEFT_SPACES = 2;

/**
 * @param $firstFilePath
 * @param $secondFilePath
 * @return string
 * @throws \Exception
 */
function genDiff($firstFilePath, $secondFilePath): string
{
    $firstFileContent = getContent($firstFilePath);
    $secondFileContent = getContent($secondFilePath);

    $firstFileFormat = getFileFormat($firstFilePath);
    $secondFileFormat = getFileFormat($secondFilePath);

    $firstData = parse($firstFileContent, $firstFileFormat);
    $secondData = parse($secondFileContent, $secondFileFormat);

    $keys = getKeys($firstData, $secondData);
    $spaces = str_repeat(' ', LEFT_SPACES);

    $node = function ($key) use ($firstData, $secondData, $spaces) {
        if (!property_exists($firstData, $key)) {
            return "{$spaces}+ {$key}: " . stringify($secondData->$key);
        }

        if (!property_exists($secondData, $key)) {
            return "{$spaces}- {$key}: " . stringify($firstData->$key);
        }

        if ($firstData->$key !== $secondData->$key) {
            return "{$spaces}- {$key}: " . stringify($firstData->$key)
                . PHP_EOL
                . "{$spaces}+ {$key}: " . stringify($secondData->$key)
            ;
        }

        return "{$spaces}  {$key}: {$firstData->$key}";
    };

    $start = "{" . PHP_EOL;
    $end = PHP_EOL . "}";
    $result = array_map($node, $keys);

    return $start . implode(PHP_EOL, $result) . $end . PHP_EOL;
}

/**
 * @param $firstData
 * @param $secondData
 * @return array
 */
function getKeys($firstData, $secondData): array
{
    $firstDataKeys = array_keys(get_object_vars($firstData));
    $secondDataKeys = array_keys(get_object_vars($secondData));

    $keys = array_unique(array_merge($firstDataKeys, $secondDataKeys));
    sort($keys, SORT_STRING | SORT_FLAG_CASE);

    return $keys;
}

/**
 * @param $value
 * @return string
 */
function stringify($value): string
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if (is_null($value)) {
        return 'null';
    }

    return "{$value}";
}
