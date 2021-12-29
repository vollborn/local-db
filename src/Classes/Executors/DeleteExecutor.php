<?php

namespace Vollborn\LocalDB\Classes\Executors;

use Vollborn\LocalDB\Classes\Row;

class DeleteExecutor extends BaseExecutor
{
    /**
     * @return array
     * @throws \Exception
     */
    public function execute(): array
    {
        $writer = $this->query->getTable()->getWriter();
        $data = $writer->read();
        $filtered = $this->applyFilters($data);

        $replaced = array_filter($data, static function ($item) use ($filtered) {
            return !in_array($item, $filtered, true);
        });

        $writer->write($replaced);
        return Row::toArray($replaced);
    }
}
