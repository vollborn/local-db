<?php

namespace LocalDB\Classes;

use LocalDB\Classes\Exceptions\LocalDBException;
use LocalDB\Traits\Initialize;

class LocalDB
{
    use Initialize;

    /**
     * @param string $table
     * @return \LocalDB\Classes\Query
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    public static function query(string $table): Query
    {
        $tableClass = self::findTable($table);
        if (!$tableClass) {
            throw new LocalDBException('Table not found.');
        }

        return new Query($tableClass);
    }

    /**
     * @param string $name
     * @return \LocalDB\Classes\Table|null
     */
    private static function findTable(string $name): ?Table
    {
        foreach (self::$tables as $table) {
            if ($table->getName() === $name) {
                return $table;
            }
        }
        return null;
    }
}
