<?php

namespace LocalDB\Traits\Query\CheckFilters;

trait CheckFilterOnString
{
    /**
     * @param string $value
     * @param string $operator
     * @param string $compareValue
     * @return bool
     */
    private function checkFilterOnString(string $value, string $operator, string $compareValue): bool
    {
        switch ($operator) {
            case '=':
                return $value === $compareValue;
            case '!=':
            case '<>':
                return $value !== $compareValue;
        }
        return false;
    }
}
