<?php

namespace Vollborn\LocalDB\Classes\Executors;

class AvgExecutor extends BaseExecutor
{
    /**
     * @param string $attribute
     * @return mixed
     * @throws \Exception
     * @noinspection PhpReturnDocTypeMismatchInspection
     */
    public function execute(string $attribute)
    {
        $data = $this->query->getTable()->getWriter()->read();
        $data = $this->applyFilters($data);

        $avg = 0;
        $count = 0;

        foreach ($data as $row) {
            $count++;
            $avg += $row->getAttribute($attribute);
        }

        return $count === 0 ? null : $avg / $count;
    }
}
