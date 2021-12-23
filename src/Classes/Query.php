<?php

namespace Vollborn\LocalDB\Classes;

class Query
{
    /**
     * @var \Vollborn\LocalDB\Classes\Table
     */
    protected Table $table;

    /**
     * @var \Vollborn\LocalDB\Classes\Executor
     */
    protected Executor $executor;

    /**
     * @var array
     */
    protected array $filters = [];

    /**
     * @var string
     */
    protected string $action;

    /**
     * @param \Vollborn\LocalDB\Classes\Table $table
     */
    public function __construct(Table $table)
    {
        $this->table = $table;
        $this->executor = new Executor($this);
    }

    /**
     * @param string $column
     * @param string $operator
     * @param mixed $value
     * @return $this
     */
    public function where(string $column, string $operator, $value): self
    {
        $this->filters[] = [$column, $operator, $value];
        return $this;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function get(): array
    {
        return $this->executor->execute(Executor::ACTION_GET);
    }

    /**
     * @return array|null
     * @throws \Vollborn\LocalDB\Classes\Exceptions\LocalDBException
     */
    public function first(): ?array
    {
        return $this->executor->execute(Executor::ACTION_FIRST);
    }

    /**
     * @return \Vollborn\LocalDB\Classes\Table
     */
    public function getTable(): Table
    {
        return $this->table;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }
}
