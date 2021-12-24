<?php

namespace Vollborn\LocalDB\Classes;

use Vollborn\LocalDB\Classes\Exceptions\LocalDBException;
use Vollborn\LocalDB\Classes\Executors\CreateExecutor;
use Vollborn\LocalDB\Classes\Executors\DeleteExecutor;
use Vollborn\LocalDB\Classes\Executors\FirstExecutor;
use Vollborn\LocalDB\Classes\Executors\GetExecutor;
use Vollborn\LocalDB\Classes\Executors\UpdateExecutor;

class Executor
{
    public const ACTION_GET = 'get';
    public const ACTION_FIRST = 'first';
    public const ACTION_CREATE = 'create';
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
                return GetExecutor::call($this->query);
            case self::ACTION_FIRST:
                return FirstExecutor::call($this->query);
            case self::ACTION_CREATE:
                return CreateExecutor::call($this->query);
            case self::ACTION_UPDATE:
                return UpdateExecutor::call($this->query);
            case self::ACTION_DELETE:
                return DeleteExecutor::call($this->query);
        }

        throw new LocalDBException();
    }
}
