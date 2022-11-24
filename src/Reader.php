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
