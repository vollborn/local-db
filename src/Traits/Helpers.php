<?php

namespace LocalDB\Traits;

use LocalDB\Classes\LocalDB;

trait Helpers
{
    /**
     * @param $path
     * @return bool
     */
    private static function createDirectoryTree($path): bool
    {
        if (!is_dir($path)) {
            return mkdir($path, 770, true);
        }
        return true;
    }

    /**
     * @param $path
     * @return bool
     */
    private static function createJsonFile($path): bool
    {
        $fullPath = LocalDB::getPath() . '/' . $path;

        if (!file_exists($fullPath)) {
            return file_put_contents($fullPath, '[]') === false;
        }

        return true;
    }
}
