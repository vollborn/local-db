<?php

namespace Vollborn\LocalDB\Classes\Executors;

class MaxExecutor extends BaseExecutor
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

        $max = null;
        foreach ($data as $row) {
            $val = $row->getAttribute($attribute);

            if ($max === null) {
                $max = $val;
                continue;
            }

            if ($val > $max) {
                $max = $val;
            }
        }

        return $max;
    }
}
