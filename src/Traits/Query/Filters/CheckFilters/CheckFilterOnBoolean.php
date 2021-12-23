<?php

namespace LocalDB\Traits\Query\Filters\CheckFilters;

trait CheckFilterOnBoolean
{
    /**
     * @param bool $value
     * @param string $operator
     * @param bool $compareValue
     * @return bool
     */
    private function checkFilterOnBoolean(bool $value, string $operator, bool $compareValue): bool
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
