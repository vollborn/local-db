<?php

namespace Vollborn\LocalDB\Classes\Executors;

use Vollborn\LocalDB\Classes\Row;

class FirstExecutor extends BaseExecutor
{
    /**
     * @return array|null
     * @throws \Exception
     */
    public function execute(): ?array
    {
        $data = $this->query->getTable()->getWriter()->read();
        $data = $this->applyFilters($data);
        $array = Row::toArray($data);
        return $array[0] ?? null;
    }
}
