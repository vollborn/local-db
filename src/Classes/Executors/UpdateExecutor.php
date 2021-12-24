<?php

namespace Vollborn\LocalDB\Classes\Executors;

use Vollborn\LocalDB\Classes\Row;

class UpdateExecutor extends BaseExecutor
{
    /**
     * @return array
     * @throws \Exception
     */
    public function execute(): array
    {
        $attributes = $this->query->getAttributes();
        $this->validateAttributes($attributes);

        $writer = $this->query->getTable()->getWriter();
        $data = $writer->read();
        $filtered = $this->applyFilters($data);

        for ($index = 0; $index < count($filtered); $index++) {
            foreach ($attributes as $attributeName => $attributeValue) {
                $filtered[$index]->setAttribute($attributeName, $attributeValue);
            }
        }

        $writer->write($data);
        return Row::toArray($filtered);
    }
}
