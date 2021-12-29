<?php

namespace Vollborn\LocalDB\Traits\Table;

use Vollborn\LocalDB\Classes\Column;

trait HasColumns
{
    /**
     * @var array
     */
    protected array $columns = [];

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
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
     * @param string $name
     * @return \Vollborn\LocalDB\Classes\Column
     */
    public function array(string $name): Column
    {
        return $this->addColumn($name, Column::TYPE_ARRAY);
    }

    /**
     * @param string $name
     * @return \Vollborn\LocalDB\Classes\Column
     */
    public function int(string $name): Column
    {
        return $this->addColumn($name, Column::TYPE_INT);
    }

    /**
     * @param string $name
     * @return \Vollborn\LocalDB\Classes\Column
     */
    public function boolean(string $name): Column
    {
        return $this->addColumn($name, Column::TYPE_BOOLEAN);
    }

    /**
     * @param string $name
     * @return \Vollborn\LocalDB\Classes\Column
     */
    public function string(string $name): Column
    {
        return $this->addColumn($name, Column::TYPE_STRING);
    }

    /**
     * @param string $name
     * @return \Vollborn\LocalDB\Classes\Column
     */
    public function float(string $name): Column
    {
        return $this->addColumn($name, Column::TYPE_FLOAT);
    }
}
