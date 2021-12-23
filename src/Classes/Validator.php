<?php

namespace LocalDB\Classes;

use LocalDB\Classes\Exceptions\LocalDBException;

class Validator
{
    /**
     * @param \LocalDB\Classes\Table $table
     * @param array $row
     * @return array
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    public static function validateTableRow(Table $table, array $row): array
    {
        $properties = $table->getProperties();
        $sanitized = [];
        foreach ($properties as $propertyName => $property) {
            $sanitized[$propertyName] = self::sanitize($property, $row);
        }
        return $sanitized;
    }

    /**
     * @param \LocalDB\Classes\Table $table
     * @param array $row
     * @return array
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    public static function sanitizeTableRow(Table $table, array $row): array
    {
        $properties = $table->getProperties();
        $sanitized = [];
        foreach ($properties as $propertyName => $property) {
            $sanitized[$propertyName] = self::sanitize($property, $row);
        }
        return $sanitized;
    }

    /**
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    private static function sanitize(TableProperty $property, array $row)
    {
        $propertyName = $property->getName();
        $propertyType = $property->getType();

        if ($propertyType === TableProperty::TYPE_ID) {
            return null;
        }

        if (!array_key_exists($propertyName, $row) || $row[$propertyName] === null) {
            if ($property->getNullable()) {
                return null;
            }

            if ($property->getDefaultValue()) {
                return $property->getDefaultValue();
            }

            throw new LocalDBException('Property ' . $propertyName . ' is not nullable.');
        }

        switch ($propertyType) {
            case TableProperty::TYPE_INTEGER:
                $value = (int)$row[$propertyName];
                if ($value > $property->getMaxlength()) {
                    throw new LocalDBException('Property ' . $propertyName . ' is too big.');
                }
                return $value;
            case TableProperty::TYPE_STRING:
                return (string)$row[$propertyName];
            case TableProperty::TYPE_FLOAT:
                return (float)$row[$propertyName];
            case TableProperty::TYPE_BOOLEAN:
                return (bool)$row[$propertyName];
        }

        throw new LocalDBException('Unsupported type: ' . $property->getType());
    }
}
