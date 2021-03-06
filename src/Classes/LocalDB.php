<?php

namespace Vollborn\LocalDB\Classes;

use Vollborn\LocalDB\Classes\Exceptions\LocalDBException;

class LocalDB
{
    /**
     * @var string
     */
    protected static string $basePath = '../storage/local-db';

    /**
     * @var array
     */
    protected static array $tables = [];

    /**
     * @param string $basePath
     * @return void
     */
    public static function setBasePath(string $basePath)
    {
        self::$basePath = $basePath;
    }

    /**
     * @return string
     */
    public static function getBasePath(): string
    {
        return self::$basePath;
    }

    /**
     * @param string $name
     * @param mixed|null $callback
     * @return \Vollborn\LocalDB\Classes\Table
     * @throws \Vollborn\LocalDB\Classes\Exceptions\LocalDBException
     */
    public static function table(string $name, $callback = null): Table
    {
        $table = new Table($name);
        self::$tables[$name] = $table;

        if ($callback) {
            call_user_func($callback, $table);
        }

        return $table;
    }

    /**
     * @param string $tableName
     * @return \Vollborn\LocalDB\Classes\Query
     * @throws \Vollborn\LocalDB\Classes\Exceptions\LocalDBException
     */
    public static function query(string $tableName): Query
    {
        if (!array_key_exists($tableName, self::$tables)) {
            throw new LocalDBException("Table not found: $tableName");
        }

        return new Query(self::$tables[$tableName]);
    }
}
