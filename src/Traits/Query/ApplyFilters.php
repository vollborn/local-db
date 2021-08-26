<?php

namespace LocalDB\Traits\Query;

use LocalDB\Classes\TableProperty;
use LocalDB\Traits\Query\CheckFilters\CheckFilterOnBoolean;
use LocalDB\Traits\Query\CheckFilters\CheckFilterOnInteger;
use LocalDB\Traits\Query\CheckFilters\CheckFilterOnString;

trait ApplyFilters
{
    use CheckFilterOnString,
        CheckFilterOnBoolean,
        CheckFilterOnInteger;

    /**
     * @return array
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    private function getDataAndApplyFilters(): array
    {
        $rows = $this->table->getAllRows();
        foreach ($this->filters as $filter) {
            $this->applyFilter($rows, $filter);
        }
        return $rows;
    }

    /**
     * @param array $rows
     * @param array $filter
     * @return array
     */
    private function applyFilter(array &$rows, array $filter): array
    {
        $rows = array_filter($rows, function ($row) use ($filter) {
            return $this->checkFilterOnRow($row, $filter);
        });
        return $rows;
    }

    private function checkFilterOnRow(array $row, array $filter): bool
    {
        $propertyName = $filter['property'];
        $properties = $this->table->getProperties();
        $propertyType = $properties[$propertyName]->getType();

        $compareValue = $filter['value'];
        $rowValue = $row[$propertyName];

        switch ($propertyType) {
            case TableProperty::TYPE_STRING:
                return $this->checkFilterOnString($rowValue, $filter['operator'], $compareValue);
            case TableProperty::TYPE_BOOLEAN:
                return $this->checkFilterOnBoolean($rowValue, $filter['operator'], $compareValue);
            case TableProperty::TYPE_INTEGER:
                return $this->checkFilterOnInteger($rowValue, $filter['operator'], $compareValue);
        }
        return false;
    }
}
