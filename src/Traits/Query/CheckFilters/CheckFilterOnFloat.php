<?php

namespace LocalDB\Traits\Query\CheckFilters;

trait CheckFilterOnFloat
{
    /**
     * @param float $value
     * @param string $operator
     * @param float $compareValue
     * @return bool
     */
    private function checkFilterOnFloat(float $value, string $operator, float $compareValue): bool
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
