<?php

namespace LocalDB\Traits;

use LocalDB\Classes\Table;

trait Initialize
{
    use Helpers;

    private static string $path;
    private static array $tables = [];

    /**
     * @param string $path
     */
    public static function setPath(string $path)
    {
        if (self::createDirectoryTree($path)) {
            self::$path = $path;
        }
    }

    /**
     * @return string
     */
    public static function getPath(): string
    {
        return self::$path;
    }

    /**
     * @param string $name
     * @param $callback
     * @return \LocalDB\Classes\Table
     * @throws \Exception
     */
    public static function initTable(string $name, $callback): Table
    {
        $table = new Table($name);
        call_user_func($callback, $table);
        self::$tables[] = $table;
        return $table;
    }
}
