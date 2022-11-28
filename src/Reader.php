<?php

namespace Differ\Reader;

use Exception;

/**
 * @param $filePath
 * @return bool|string
 * @throws Exception
 */
function getContent($filePath)
{
    if (!file_exists($filePath)) {
        throw new Exception("File '$filePath' does not exists");
    }

    return file_get_contents($filePath);
}

/**
 * @param $filePath
 * @return array|string|string[]
 */
function getFileFormat($filePath)
{
    return pathinfo($filePath, PATHINFO_EXTENSION);
}
