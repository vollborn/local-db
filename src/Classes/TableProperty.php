<?php

namespace LocalDB\Classes;

use LocalDB\Classes\Exceptions\LocalDBException;

class TableProperty
{
    public const TYPE_ID = 'id';
    public const TYPE_STRING = 'string';
    public const TYPE_INTEGER = 'integer';
    public const TYPE_BOOLEAN = 'boolean';
    public const TYPE_FLOAT = 'float';

    public const AVAILABLE_TYPES = [
        self::TYPE_ID,
        self::TYPE_STRING,
        self::TYPE_INTEGER,
        self::TYPE_BOOLEAN,
        self::TYPE_FLOAT
    ];

    private string $type;
    private string $name;
    private ?int $maxlength;
    private bool $isNullable = false;
    private $defaultValue;

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
     * @return $this
     */
    public function nullable(): TableProperty
    {
        $this->isNullable = true;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function default($value): TableProperty
    {
        $this->defaultValue = $value;
        return $this;
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
     * @return bool
     */
    public function getNullable(): bool
    {
        return $this->isNullable;
    }

    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
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
