<?php

namespace Vollborn\LocalDB\Classes\Executors;

use Vollborn\LocalDB\Classes\Exceptions\LocalDBException;
use Vollborn\LocalDB\Classes\Query;
use Vollborn\LocalDB\Classes\Validator;

abstract class BaseExecutor
{
    /**
     * @var \Vollborn\LocalDB\Classes\Query
     */
    protected Query $query;

    /**
     * @param \Vollborn\LocalDB\Classes\Query $query
     * @return mixed
     */
    public static function call(Query $query)
    {
        $called = get_called_class();
        return (new $called($query))->execute();
    }

    public abstract function execute();

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
     * @param array $attributes
     * @return void
     * @throws \Vollborn\LocalDB\Classes\Exceptions\LocalDBException
     */
    protected function validateAttributes(array $attributes)
    {
        $columns = $this->query->getTable()->getColumns();
        if (!Validator::columns($columns, $attributes)) {
            throw new LocalDBException();
        }
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
