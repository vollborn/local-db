<?php

namespace Vollborn\LocalDB\Classes\Executors;

use Vollborn\LocalDB\Classes\Query;
use Vollborn\LocalDB\Classes\Row;

class BaseExecutor
{
    /**
     * @var \Vollborn\LocalDB\Classes\Query
     */
    protected Query $query;

    /**
     * @param \Vollborn\LocalDB\Classes\Query $query
     */
    public function __construct(Query $query)
    {
        $this->query = $query;
    }

    /**
     * @param array $data
     * @return array
     * @throws \Vollborn\LocalDB\Classes\Exceptions\LocalDBException
     */
    protected function applyFilters(array $data): array
    {
        foreach ($this->query->getFilters() as $filter) {
            switch ($filter[1]) {
                case "=":
                    $data = array_filter($data, static function (Row $item) use ($filter) {
                        return $item->getAttribute($filter[0]) === $filter[2];
                    });
                    break;
                case "!=":
                case "<>":
                    $data = array_filter($data, static function (Row $item) use ($filter) {
                        return $item->getAttribute($filter[0]) !== $filter[2];
                    });
                    break;
                case "<":
                    $data = array_filter($data, static function (Row $item) use ($filter) {
                        return $item->getAttribute($filter[0]) < $filter[2];
                    });
                    break;
                case ">":
                    $data = array_filter($data, static function (Row $item) use ($filter) {
                        return $item->getAttribute($filter[0]) > $filter[2];
                    });
                    break;
                case "<=":
                    $data = array_filter($data, static function (Row $item) use ($filter) {
                        return $item->getAttribute($filter[0]) <= $filter[2];
                    });
                    break;
                case ">=":
                    $data = array_filter($data, static function (Row $item) use ($filter) {
                        return $item->getAttribute($filter[0]) >= $filter[2];
                    });
                    break;
            }
        }

        $data = $this->applyOrderBy($data);
        return $this->cleanupArrayKeys($data);
    }

    /**
     * @param array $data
     * @return array
     */
    protected function cleanupArrayKeys(array $data): array
    {
        $cleaned = [];
        foreach ($data as $item) {
            $cleaned[] = $item;
        }
        return $cleaned;
    }

    /**
     * @param array $data
     * @return array
     */
    protected function applyOrderBy(array $data): array
    {
        $orderByColumn = $this->query->getOrderByColumn();
        $orderByDesc = $this->query->getOrderByDesc();

        if ($orderByColumn) {
            if ($orderByDesc) {
                usort($data, static function ($carry, $item) use ($orderByColumn) {
                    return $carry->getAttribute($orderByColumn) < $item->getAttribute($orderByColumn);
                });
            } else {
                usort($data, static function ($carry, $item) use ($orderByColumn) {
                    return $carry->getAttribute($orderByColumn) > $item->getAttribute($orderByColumn);
                });
            }
        }

        return $data;
    }
}
