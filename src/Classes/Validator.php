<?php

namespace Vollborn\LocalDB\Classes;

class Validator
{
    /**
     * @param array $columns
     * @param array $attributes
     * @return bool
     */
    public static function columns(array $columns, array $attributes): bool
    {
        // check if required columns are specified
        foreach ($columns as $column) {
            $name = $column->getName();
            $isRequired = !$column->getNullable() || !$column->getAutoincrements();
            if ($isRequired && !isset($attributes[$name])) {
                return false;
            }
        }

        // check if attribute values itself are valid
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
        return true;
    }
}
