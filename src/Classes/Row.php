<?php

namespace Vollborn\LocalDB\Classes;

use Vollborn\LocalDB\Classes\Exceptions\LocalDBException;

class Row
{
    /**
     * @var array
     */
    protected array $attributes;

    /**
     * @param array $rows
     * @return array
     */
    public static function toArray(array $rows): array
    {
        return array_map(static function ($item) {
            return $item->getAttributes();
        }, $rows);
    }

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param string $name
     * @return mixed
     * @throws \Vollborn\LocalDB\Classes\Exceptions\LocalDBException
     */
    public function getAttribute(string $name)
    {
        if (!array_key_exists($name, $this->attributes)) {
            throw new LocalDBException("Column not found: $name");
        }
        return $this->attributes[$name];
    }

    /**
     * @param string $name
     * @param $value
     * @return $this
     */
    public function setAttribute(string $name, $value): self
    {
        $this->attributes[$name] = $value;
        return $this;
    }
}
