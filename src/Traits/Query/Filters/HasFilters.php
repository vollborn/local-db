<?php

namespace LocalDB\Traits\Query\Filters;

use LocalDB\Classes\Exceptions\LocalDBException;
use LocalDB\Classes\Query;

trait HasFilters
{
    use ApplyFilters;

    private array $filters = [];

    /**
     * @param $property
     * @param $operator
     * @param $value
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    private function addFilter($property, $operator, $value)
    {
        if (!array_key_exists($property, $this->table->getProperties())) {
            throw new LocalDBException('Table ' . $this->table->getName() . ' has no property ' . $property . '.');
        }

        $this->filters[] = [
            'property' => $property,
            'operator' => $operator,
            'value'    => $value
        ];
    }

    /**
     * @param $property
     * @param $operator
     * @param null $value
     * @return \LocalDB\Classes\Query
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    public function where($property, $operator, $value = null): Query
    {
        if (!$value) {
            $value = $operator;
            $operator = '=';
        }

        $this->addFilter($property, $operator, $value);
        return $this;
    }
}
