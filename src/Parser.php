<?php

namespace Differ\Parser;

use Exception;
use Symfony\Component\Yaml\Yaml;

/**
 * @param mixed $data
 * @param string $format
 * @return mixed
 * @throws Exception
 */
function parse(mixed $data, string $format): mixed
{
    return match ($format) {
        'json' => json_decode($data),
        'yaml', 'yml' => Yaml::parse($data, Yaml::PARSE_OBJECT_FOR_MAP),
        default => throw new Exception("The file format '$format' is not supported"),
    };
}
