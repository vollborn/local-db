<?php

namespace Vollborn\LocalDB\Classes\Executors;

use Vollborn\LocalDB\Classes\Row;

class GetExecutor extends BaseExecutor
{
    /**
     * @return array
     * @throws \Exception
     */
    public function execute(): array
    {
        $data = $this->query->getTable()->getWriter()->read();
        $data = $this->applyFilters($data);
        return Row::toArray($data);
    }
}
