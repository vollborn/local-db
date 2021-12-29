<?php

namespace Vollborn\LocalDB\Classes\Executors;

class SumExecutor extends BaseExecutor
{
    /**
     * @param string $attribute
     * @return mixed
     * @throws \Exception
     */
    public function execute(string $attribute)
    {
        $data = $this->query->getTable()->getWriter()->read();
        $data = $this->applyFilters($data);

        $sum = 0;

        foreach ($data as $row) {
            $attributes = $row->getAttributes();
            $sum += $attributes[$attribute];
        }

        return $sum;
    }
}
