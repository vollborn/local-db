<?php

namespace LocalDB\Traits\Table;

use Exception;
use LocalDB\Classes\Exceptions\LocalDBException;
use LocalDB\Classes\LocalDB;
use LocalDB\Classes\Validator;

trait CanAddRows
{
    /**
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    public function generateId()
    {
        $rows = $this->getAllRows();
        if (empty($rows)) {
            return 1;
        }

        $ids = array_map(static function ($row) {
            return $row['id'];
        }, $rows);

        return max($ids) + 1;
    }

    /**
     * @param $data
     * @return array
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    public function addRow($data): array
    {
        $sanitized = Validator::sanitizeTableRow($this, $data);
        $sanitized['id'] = $this->generateId();

        $rows = $this->getAllRows();
        $rows[] = $sanitized;

        if (!$this->writeRows($rows)) {
            throw new LocalDBException('Could not add row.');
        };

        return $sanitized;
    }

    /**
     * @param array $rows
     * @return bool
     */
    public function writeRows(array $rows): bool
    {
        try {
            $writeData = json_encode($rows, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
            if (!file_put_contents(LocalDB::getPath() . '/' . $this->filepath, $writeData)) {
                return false;
            };
        } catch (Exception $exception) {
            return false;
        }
        return true;
    }
}
