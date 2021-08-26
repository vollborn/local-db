<?php

namespace LocalDB\Classes;

use LocalDB\Traits\Query\GetQueryData;
use LocalDB\Traits\Query\HasFilters;

class Query
{
    use HasFilters,
        GetQueryData;

    private Table $table;

    /**
     * @param \LocalDB\Classes\Table $table
     */
    public function __construct(Table $table)
    {
        $this->table = $table;
    }
}
