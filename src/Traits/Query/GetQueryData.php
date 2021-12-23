<?php

namespace LocalDB\Traits\Query;

use LocalDB\Classes\Model;

trait GetQueryData
{
    /**
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    public function get()
    {
        $rows = $this->getDataAndApplyFilters();
        return $this->mapRowsToModel($rows);
    }

    /**
     * @return array|null
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    public function first(): ?Model
    {
        $rows = $this->getDataAndApplyFilters();
        $mappedRows = $this->mapRowsToModel($rows);
        return empty($mappedRows)
            ? null
            : $mappedRows[0];
    }

    /**
     * @return array|null
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    public function last(): ?Model
    {
        $rows = $this->getDataAndApplyFilters();
        $mappedRows = $this->mapRowsToModel($rows);
        return empty($mappedRows)
            ? null
            : $mappedRows[sizeof($mappedRows) - 1];
    }

    /**
     * @param array $rows
     * @return mixed
     */
    private function mapRowsToModel(array $rows)
    {
        $mappedRows = [];

        foreach ($rows as $row) {
            $model = new Model($this->table);
            $model->forceFill($row);
            $mappedRows[] = $model;
        }

        // Laravel specific
        if (class_exists('\Illuminate\Support\Collection')) {
            return new \Illuminate\Support\Collection($mappedRows);
        }

        return $mappedRows;
    }
}
