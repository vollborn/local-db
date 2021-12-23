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
     * @return \Vollborn\LocalDB\Classes\Table
     */
    public static function table(string $name): Table
    {
        $table = new Table($name);
        self::$tables[] = $table;
        return $table;
    }

    /**
     * @param string $tableName
     * @return \Vollborn\LocalDB\Classes\Query
     * @throws \Vollborn\LocalDB\Classes\Exceptions\LocalDBException
     */
    public static function query(string $tableName): Query
    {
        $usedTable = null;

        foreach (self::$tables as $table) {
            if ($table->getName() === $tableName) {
                $usedTable = $table;
                break;
            }
        }

        if (!$usedTable) {
            throw new LocalDBException();
        }

        return new Query($usedTable);
    }
}
