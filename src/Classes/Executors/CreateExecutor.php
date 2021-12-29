<?php

namespace Vollborn\LocalDB\Classes\Executors;

use Vollborn\LocalDB\Classes\Exceptions\LocalDBException;
use Vollborn\LocalDB\Classes\Query;
use Vollborn\LocalDB\Classes\Row;
use Vollborn\LocalDB\Classes\Validator;

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
        $columns = $this->query->getTable()->getColumns();

        if (
            !Validator::hasRequiredColumns($columns, $attributes)
            || !Validator::columns($columns, $attributes)
        ) {
            throw new LocalDBException("Create validation failed. Attributes: " . json_encode($attributes));
        }

        $writer = $this->query->getTable()->getWriter();
        $data = $writer->read();
        $preCreateData = $this->preCreate($attributes, $columns);
        $data[] = new Row($preCreateData);
        $writer->write($data);

        return $preCreateData;
    }

    /**
     * @param array $attributes
     * @param array $columns
     * @return array
     * @throws \Exception
     */
    protected function preCreate(array $attributes, array $columns): array
    {
        // apply autoincrements
        $autoincrementColumns = array_filter($columns, static function ($column) {
            return $column->getAutoincrements();
        });

        foreach ($autoincrementColumns as $autoincrementColumn) {
            $name = $autoincrementColumn->getName();
            if (!array_key_exists($name, $attributes)) {
                $query = new Query($this->query->getTable());
                $max = $query->max($name) + 1 ?? 1;
                $attributes[$name] = $max;
            }
        }

        return $attributes;
    }
}
