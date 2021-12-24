<?php

namespace Vollborn\LocalDB\Classes;

class Table
{
    /**
     * @var string
     */
    protected string $name;

    /**
     * @var array
     */
    protected array $columns = [];

    /**
     * @var \Vollborn\LocalDB\Classes\Writer
     */
    protected Writer $writer;

    /**
     * @var bool
     */
    protected bool $isReadonly = false;

    /**
     * @param string $name
     * @throws \Vollborn\LocalDB\Classes\Exceptions\LocalDBException
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->writer = new Writer($this);
    }

    /**
     * @param string $name
     * @param string $type
     * @return \Vollborn\LocalDB\Classes\Column
     */
    public function addColumn(string $name, string $type): Column
    {
        $column = new Column($name, $type);
        $this->columns[] = $column;
        return $column;
    }

    /**
     * @param bool $isReadonly
     * @return void
     */
    public function readonly(bool $isReadonly = true)
    {
        $this->isReadonly = $isReadonly;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return \Vollborn\LocalDB\Classes\Writer
     */
    public function getWriter(): Writer
    {
        return $this->writer;
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }
}
