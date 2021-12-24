<?php

namespace Vollborn\LocalDB\Classes;

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
     * @param $value
     * @return $this
     */
    public function setAttribute(string $name, $value): self
    {
        $this->attributes[$name] = $value;
        return $this;
    }
}
