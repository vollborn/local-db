<?php

namespace LocalDB\Traits\Query;

use LocalDB\Classes\Validator;

trait CanUpdate
{
    /**
     * @param array $data
     * @return bool
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    public function update(array $data): bool
    {
        $allRows = $this->table->getAllRows();
        $rows = $this->getDataAndApplyFilters();

        $sanitized = Validator::sanitizeTableRow($this->table, $data);

        foreach ($rows as $row) {
            foreach ($sanitized as $key => $value) {
                $row[$key] = $value;
            }

            foreach ($allRows as $index => $allRow) {
                if ($allRow['id'] === $row['id']) {
                    $allRows[$index] = $row;
                    break;
                }
            }
        }

        $this->table->writeRows($allRows);
        return true;
    }
}
