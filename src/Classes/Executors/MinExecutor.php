<?php

namespace Vollborn\LocalDB\Classes\Executors;

use Vollborn\LocalDB\Classes\Row;

class MinExecutor extends BaseExecutor
{
    /**
     * @param string $attribute
     * @return array
     * @throws \Exception
     */
    public function execute(string $attribute): array
    {
        $data = $this->query->getTable()->getWriter()->read();
        $data = $this->applyFilters($data);

        /** @var Row $row */
        $row = array_reduce($data, static function ($carry, $item) use ($attribute) {
            if (!$carry) {
                return $item;
            }

            $carryAttributes = $carry->getAttributes();
            $itemAttributes = $item->getAttributes();
            return $carryAttributes[$attribute] < $itemAttributes[$attribute] ? $carry : $item;
        });

        return $row->getAttributes();
    }
}
