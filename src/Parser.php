<?php

namespace Differ\Parser;

use Exception;
use Symfony\Component\Yaml\Yaml;

/**
 * @param $data
 * @param $format
 * @return mixed
 * @throws Exception
 */
function parse($data, $format)
{
    switch ($format) {
        case 'json':
            return json_decode($data);
        case 'yaml':
        case 'yml':
            return Yaml::parse($data, Yaml::PARSE_OBJECT_FOR_MAP);
        default:
            throw new Exception("The file format '$format' is not supported");
    }
}
