<?php

namespace LocalDB\Traits;

use LocalDB\Classes\Exceptions\LocalDBException;
use LocalDB\Classes\TableProperty;

trait HasTableProperties
{
    private array $properties = [];

    /**
     * @param string $type
     * @param string $propertyName
     * @param int|null $maxlength
     * @return \LocalDB\Classes\TableProperty
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    private function addProperty(string $type, string $propertyName, ?int $maxlength = null): TableProperty
    {
        if (array_key_exists($propertyName, $this->properties)) {
            throw new LocalDBException('Matching property names are not allowed.');
        }

        $property = new TableProperty($type, $propertyName, $maxlength);
        $this->properties[$propertyName] = $property;
        return $property;
    }

    /**
     * @param string $propertyName
     * @param int|null $maxlength
     * @return \LocalDB\Classes\TableProperty
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    public function string(string $propertyName, ?int $maxlength = null): TableProperty
    {
        return $this->addProperty(TableProperty::TYPE_STRING, $propertyName, $maxlength);
    }

    /**
     * @param string $propertyName
     * @param int|null $maxlength
     * @return \LocalDB\Classes\TableProperty
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    public function integer(string $propertyName, ?int $maxlength = null): TableProperty
    {
        return $this->addProperty(TableProperty::TYPE_INTEGER, $propertyName, $maxlength);
    }

    /**
     * @param string $propertyName
     * @return \LocalDB\Classes\TableProperty
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    public function boolean(string $propertyName): TableProperty
    {
        return $this->addProperty(TableProperty::TYPE_INTEGER, $propertyName);
    }

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return $this->properties;
    }
}
