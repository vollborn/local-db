<?php

namespace LocalDB\Traits\Model;

use LocalDB\Classes\LocalDB;

trait CanSave
{
    /**
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    public function save()
    {
        $oldAttributes = $this->attributes;

        $attributes = [];
        foreach (array_keys($oldAttributes) as $key) {
            $attributes[$key] = $this->$key;
        }

        $changes = array_diff($attributes, $oldAttributes);
        LocalDB::query($this->table->getName())
            ->where('id', '=', $this->id)
            ->update($changes);
    }
}
