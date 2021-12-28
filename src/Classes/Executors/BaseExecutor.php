<?php

namespace Vollborn\LocalDB\Classes\Executors;

use Vollborn\LocalDB\Classes\Query;

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
     */
    protected function applyFilters(array $data): array
    {
        foreach ($this->query->getFilters() as $filter) {
            switch ($filter[1]) {
                case "=":
                    $data = array_filter($data, static function ($item) use ($filter) {
                        $array = $item->getAttributes();
                        return $array[$filter[0]] === $filter[2];
                    });
                    break;
                case "!=":
                case "<>":
                    $data = array_filter($data, static function ($item) use ($filter) {
                        $array = $item->getAttributes();
                        return $array[$filter[0]] !== $filter[2];
                    });
                    break;
            }
        }

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
}
