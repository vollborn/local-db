<?php

namespace Vollborn\LocalDB\Classes\Executors;

use Vollborn\LocalDB\Classes\Exceptions\LocalDBException;
use Vollborn\LocalDB\Classes\Row;
use Vollborn\LocalDB\Classes\Validator;

class CreateExecutor extends BaseExecutor
{
    /**
     * @return array
     * @throws \Vollborn\LocalDB\Classes\Exceptions\LocalDBException
     * @throws \Exception
     */
    public function execute(): array
    {
        $attributes = $this->query->getAttributes();

        $columns = $this->query->getTable()->getColumns();
        if (
            !Validator::hasRequiredColumns($columns, $attributes)
            || !Validator::columns($columns, $attributes)
        ) {
            throw new LocalDBException();
        }

        $writer = $this->query->getTable()->getWriter();
        $data = $writer->read();
        $data[] = new Row($attributes);
        $writer->write($data);

        return $attributes;
    }
}
