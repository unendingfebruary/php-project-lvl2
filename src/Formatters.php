<?php

namespace Differ\Formatters;

use Exception;

use function Differ\Formatters\Plain\formatToPlain;
use function Differ\Formatters\Stylish\formatToStylish;

const STYLISH_FORMAT = 'stylish';
const PLAIN_FORMAT = 'plain';

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
        default => throw new Exception("Format '$format' is not supported"),
    };
}
