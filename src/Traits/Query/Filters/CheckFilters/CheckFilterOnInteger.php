<?php

namespace LocalDB\Traits\Query\Filters\CheckFilters;

trait CheckFilterOnInteger
{
    /**
     * @param int $value
     * @param string $operator
     * @param int $compareValue
     * @return bool
     */
    private function checkFilterOnInteger(int $value, string $operator, int $compareValue): bool
    {
        switch ($operator) {
            case '=':
                return $value === $compareValue;
            case '!=':
            case '<>':
                return $value !== $compareValue;
            case '<':
                return $value < $compareValue;
            case '>':
                return $value > $compareValue;
            case '<=':
                return $value <= $compareValue;
            case '>=':
                return $value >= $compareValue;
        }
        return false;
    }
}
