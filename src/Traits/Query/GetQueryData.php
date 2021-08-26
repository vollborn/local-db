<?php

namespace LocalDB\Traits\Query;

trait GetQueryData
{
    /**
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    public function get(): array
    {
        return $this->getDataAndApplyFilters();
    }

    /**
     * @param int $count
     * @return array|null
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    public function first(int $count = 1): ?array
    {
        $rows = $this->getDataAndApplyFilters();
        return empty($rows)
            ? null
            : array_slice($rows, 0, $count);
    }

    /**
     * @param int $count
     * @return array|null
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    public function last(int $count = 1): ?array
    {
        $rows = $this->getDataAndApplyFilters();
        return empty($rows)
            ? null
            : array_slice($rows, sizeof($rows) - $count);
    }
}
