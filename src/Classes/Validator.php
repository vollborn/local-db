<?php

namespace Vollborn\LocalDB\Classes;

use Vollborn\LocalDB\Classes\Validators\ArrayValidator;
use Vollborn\LocalDB\Classes\Validators\BooleanValidator;
use Vollborn\LocalDB\Classes\Validators\FloatValidator;
use Vollborn\LocalDB\Classes\Validators\IntValidator;
use Vollborn\LocalDB\Classes\Validators\StringValidator;

class Validator
{
    /**
     * @param array $columns
     * @param array $attributes
     * @return bool
     */
    public static function hasRequiredColumns(array $columns, array $attributes): bool
    {
        foreach ($columns as $column) {
            $name = $column->getName();
            $isRequired = !$column->getNullable() || !$column->getAutoincrements();
            if ($isRequired && !isset($attributes[$name])) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array $columns
     * @param array $attributes
     * @return bool
     */
    public static function columns(array $columns, array $attributes): bool
    {
        foreach ($attributes as $attributeName => $attributeValue) {
            $usedColumn = null;

            foreach ($columns as $column) {
                if ($column->getName() === $attributeName) {
                    $usedColumn = $column;
                    break;
                }
            }

            if (
                !$usedColumn
                || !self::column($usedColumn, $attributeValue)
            ) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param \Vollborn\LocalDB\Classes\Column $column
     * @param $value
     * @return bool
     */
    public static function column(Column $column, $value): bool
    {
        switch ($column->getType()) {
            case Column::TYPE_STRING:
                return StringValidator::call($column, $value);
            case Column::TYPE_INT:
                return IntValidator::call($column, $value);
            case Column::TYPE_BOOLEAN:
                return BooleanValidator::call($column, $value);
            case Column::TYPE_FLOAT:
                return FloatValidator::call($column, $value);
            case Column::TYPE_ARRAY:
                return ArrayValidator::call($column, $value);
        }

        return false;
    }
}
