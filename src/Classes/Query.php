<?php

namespace Vollborn\LocalDB\Classes;

use Vollborn\LocalDB\Classes\Executors\AvgExecutor;
use Vollborn\LocalDB\Classes\Executors\CreateExecutor;
use Vollborn\LocalDB\Classes\Executors\DeleteExecutor;
use Vollborn\LocalDB\Classes\Executors\FirstExecutor;
use Vollborn\LocalDB\Classes\Executors\GetExecutor;
use Vollborn\LocalDB\Classes\Executors\MaxExecutor;
use Vollborn\LocalDB\Classes\Executors\MinExecutor;
use Vollborn\LocalDB\Classes\Executors\UpdateExecutor;

class Query
{
    /**
     * @var \Vollborn\LocalDB\Classes\Table
     */
    protected Table $table;

    /**
     * @var array
     */
    protected array $filters = [];

    /**
     * @var array
     */
    protected array $attributes = [];

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
        $executor = new GetExecutor($this);
        return $executor->execute();
    }

    /**
     * @return array|null
     * @throws \Exception
     */
    public function first(): ?array
    {
        $executor = new FirstExecutor($this);
        return $executor->execute();
    }

    /**
     * @param array $attributes
     * @return array
     * @throws \Vollborn\LocalDB\Classes\Exceptions\LocalDBException
     */
    public function create(array $attributes): array
    {
        $this->attributes = $attributes;

        $executor = new CreateExecutor($this);
        return $executor->execute();
    }

    /**
     * @param array $attributes
     * @return array|null
     * @throws \Exception
     */
    public function update(array $attributes): ?array
    {
        $this->attributes = $attributes;

        $executor = new UpdateExecutor($this);
        return $executor->execute();
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function delete(): array
    {
        $executor = new DeleteExecutor($this);
        return $executor->execute();
    }

    /**
     * @param string $attribute
     * @return mixed
     * @throws \Exception
     */
    public function max(string $attribute)
    {
        $executor = new MaxExecutor($this);
        return $executor->execute($attribute);
    }

    /**
     * @param string $attribute
     * @return mixed
     * @throws \Exception
     */
    public function min(string $attribute)
    {
        $executor = new MinExecutor($this);
        return $executor->execute($attribute);
    }

    /**
     * @param string $attribute
     * @return mixed
     * @throws \Exception
     */
    public function avg(string $attribute)
    {
        $executor = new AvgExecutor($this);
        return $executor->execute($attribute);
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

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
