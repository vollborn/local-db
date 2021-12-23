<?php

namespace LocalDB\Classes;

use LocalDB\Classes\Exceptions\LocalDBException;
use LocalDB\Traits\Base\HasReservedProperties;
use LocalDB\Traits\Base\Initialize;

class LocalDB
{
    use Initialize,
        HasReservedProperties;

    /**
     * @param string $table
     * @return \LocalDB\Classes\Query
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    public static function query(string $table): Query
    {
        $tableClass = self::findTable($table);
        return new Query($tableClass);
    }

    /**
     * @param string $table
     * @param array $data
     * @return \LocalDB\Classes\Model
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    public static function create(string $table, array $data): Model
    {
        $tableClass = self::findTable($table);
        $model = new Model($tableClass);
        $model->forceFill($tableClass->addRow($data));
        return $model;
    }

    /**
     * @param string $name
     * @return \LocalDB\Classes\Table
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    private static function findTable(string $name): Table
    {
        if (!array_key_exists($name, self::$tables)) {
            throw new LocalDBException('Table not found.');
        }
        return self::$tables[$name];
    }
}
