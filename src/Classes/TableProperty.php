<?php

namespace LocalDB\Classes;

use LocalDB\Classes\Exceptions\LocalDBException;

class TableProperty
{
    public const TYPE_STRING = 'string';
    public const TYPE_INTEGER = 'integer';
    public const TYPE_BOOLEAN = 'boolean';

    public const AVAILABLE_TYPES = [
        self::TYPE_STRING,
        self::TYPE_INTEGER,
        self::TYPE_BOOLEAN
    ];

    private string $type;
    private string $name;
    private ?int $maxlength;

    /**
     * @param string $type
     * @param string $name
     * @param int|null $maxlength
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    public function __construct(string $type, string $name, ?int $maxlength)
    {
        if (!$this->hasType($type)) {
            throw new LocalDBException('Type not found.');
        }

        if ($maxlength !== null && $maxlength < 1) {
            throw new LocalDBException('The maxlength cannot be smaller than 1.');
        }

        $this->type = $type;
        $this->name = $name;
        $this->maxlength = $maxlength;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int|null
     */
    public function getMaxlength(): ?int
    {
        return $this->maxlength;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return bool
     */
    private function hasType(string $type): bool
    {
        return in_array($type, self::AVAILABLE_TYPES, true);
    }
}
