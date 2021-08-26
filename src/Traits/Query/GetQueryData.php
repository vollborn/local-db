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
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    public function first(): ?array
    {
        $rows = $this->getDataAndApplyFilters();
        return sizeof($rows)
            ? $rows[0]
            : null;
    }
}
