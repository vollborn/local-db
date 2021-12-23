<?php

namespace LocalDB\Classes;

use LocalDB\Traits\Query\CanUpdate;
use LocalDB\Traits\Query\GetQueryData;
use LocalDB\Traits\Query\Filters\HasFilters;

class Query
{
    use HasFilters,
        GetQueryData,
        CanUpdate;

    private Table $table;

    /**
     * @param \LocalDB\Classes\Table $table
     */
    public function __construct(Table $table)
    {
        $this->table = $table;
    }
}
