<?php

namespace Vollborn\LocalDB\Classes;

class Column
{
    public const TYPE_STRING = 'string';
    public const TYPE_INT = 'int';
    public const TYPE_FLOAT = 'float';
    public const TYPE_BOOLEAN = 'boolean';
    public const TYPE_ARRAY = 'array';

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $type;

    /**
     * @var bool
     */
    protected bool $isNullable = false;

    /**
     * @var bool
     */
    protected bool $hasAutoincrements = false;

    /**
     * @param string $name
     * @param string $type
     */
    public function __construct(string $name, string $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @param bool $isNullable
     * @return void
     */
    public function nullable(bool $isNullable = true)
    {
        $this->isNullable = $isNullable;
    }

    /**
     * @param bool $hasAutoincrements
     * @return void
     */
    public function autoincrements(bool $hasAutoincrements = true)
    {
        $this->hasAutoincrements = $hasAutoincrements;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
     * @return bool
     */
    public function getAutoincrements(): bool
    {
        return $this->hasAutoincrements;
    }
}
