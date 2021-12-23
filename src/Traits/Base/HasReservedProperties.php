<?php

namespace LocalDB\Traits\Base;

trait HasReservedProperties
{
    private static array $reservedProperties = [
        'id'
    ];

    /**
     * @return array
     */
    public static function getReservedProperties(): array
    {
        return self::$reservedProperties;
    }
}
