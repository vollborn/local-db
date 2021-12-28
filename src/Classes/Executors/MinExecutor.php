<?php

namespace Vollborn\LocalDB\Classes\Executors;

class MinExecutor extends BaseExecutor
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

        $min = null;
        foreach ($data as $row) {
            $attributes = $row->getAttributes();
            $val = $attributes[$attribute];

            if ($min === null) {
                $min = $val;
                continue;
            }

            if ($val < $min) {
                $min = $val;
            }
        }

        return $min;
    }
}
