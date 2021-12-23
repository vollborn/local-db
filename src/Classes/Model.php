<?php

namespace LocalDB\Classes;

use LocalDB\Traits\Model\CanFill;
use LocalDB\Traits\Model\CanSave;

class Model
{
    use CanFill,
        CanSave;

    private array $attributes;
    private Table $table;



    public function __construct(Table $table)
    {
        $this->table = $table;
    }


}
