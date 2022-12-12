<?php

namespace Differ\Formatters;

use Exception;

use function Differ\Formatters\Plain\formatToPlain;
use function Differ\Formatters\Stylish\formatToStylish;

const STYLISH_FORMAT = 'stylish';
const PLAIN_FORMAT = 'plain';
const JSON_FORMAT = 'json';

/**
 * @param $data
 * @param $format
 * @return string
 * @throws Exception
 */
function render($data, $format): string
{
    return match ($format) {
        STYLISH_FORMAT => formatToStylish($data),
        PLAIN_FORMAT => formatToPlain($data),
        JSON_FORMAT => json_encode($data, JSON_PRETTY_PRINT),
        default => throw new Exception("Format '$format' is not supported"),
    };
}
