<?php

namespace Differ\Render;

use Exception;

use function Differ\Formatters\Stylish\formatToStylish;

const STYLISH_FORMAT = 'stylish';

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
        default => throw new Exception("Format '$format' is not supported"),
    };
}
