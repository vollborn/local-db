<?php

namespace Vollborn\LocalDB\Classes;

class Column
{
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
}
