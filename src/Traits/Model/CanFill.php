<?php

namespace LocalDB\Traits\Model;

use LocalDB\Classes\Exceptions\LocalDBException;

trait CanFill
{
    /**
     * @param array $attributes
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    public function fill(array $attributes)
    {
        $properties = $this->table->getProperties();
        foreach ($attributes as $attribute => $value) {
            if (!array_key_exists($attribute, $properties)) {
                throw new LocalDBException('Property ' . $attribute . ' does not exist.');
            }

            if (in_array($attribute, $this->reservedProperties, true)) {
                continue;
            }

            $this->$attribute = $value;
        }
        $this->attributes = $attributes;
    }

    public function forceFill(array $attributes)
    {
        foreach ($attributes as $attribute => $value) {
            $this->$attribute = $value;
        }
        $this->attributes = $attributes;
    }
}
