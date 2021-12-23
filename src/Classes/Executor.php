<?php

namespace Vollborn\LocalDB\Classes;

use Vollborn\LocalDB\Classes\Exceptions\LocalDBException;

class Executor
{
    public const ACTION_GET = 'get';
    public const ACTION_FIRST = 'first';
    public const ACTION_UPDATE = 'update';
    public const ACTION_DELETE = 'delete';

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
     * @param string $actionType
     * @return array
     * @throws \Vollborn\LocalDB\Classes\Exceptions\LocalDBException
     * @throws \Exception
     */
    public function execute(string $actionType): ?array
    {
        switch ($actionType) {
            case self::ACTION_GET:
                $data = $this->query->getTable()->getWriter()->read();
                return $this->applyFilters($data);
            case self::ACTION_FIRST:
                $data = $this->query->getTable()->getWriter()->read();
                $data = $this->applyFilters($data);
                return $data[0] ?? null;
        }

        throw new LocalDBException();
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
                        return $item[$filter[0]] === $filter[2];
                    });
                    break;
                case "!=":
                case "<>":
                    $data = array_filter($data, static function ($item) use ($filter) {
                        return $item[$filter[0]] !== $filter[2];
                    });
                    break;
            }
        }

        return $data;
    }
}
