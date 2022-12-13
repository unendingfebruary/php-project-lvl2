<?php

namespace Differ\Reader;

use Exception;

/**
 * @param string $filePath
 * @return false|string
 * @throws Exception
 */
function getContent(string $filePath): bool|string
{
    if (!file_exists($filePath)) {
        throw new Exception("File '$filePath' does not exists");
    }

    return file_get_contents($filePath);
}

/**
 * @param string $filePath
 * @return array|string
 */
function getFileFormat(string $filePath): array|string
{
    return pathinfo($filePath, PATHINFO_EXTENSION);
}
