<?php

namespace Vollborn\LocalDB\Classes\Executors;

use Vollborn\LocalDB\Classes\Row;

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
        $this->validateAttributes($attributes);

        $writer = $this->query->getTable()->getWriter();
        $data = $writer->read();
        $data[] = new Row($attributes);
        $writer->write($data);

        return $attributes;
    }
}
