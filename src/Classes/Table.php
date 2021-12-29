<?php

namespace Vollborn\LocalDB\Classes;

use Vollborn\LocalDB\Traits\Table\HasColumns;

class Table
{
    use HasColumns;

    /**
     * @var string
     */
    protected string $name;

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
}
