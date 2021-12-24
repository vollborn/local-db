<?php

namespace Vollborn\LocalDB\Classes;

use Vollborn\LocalDB\Classes\Exceptions\LocalDBException;

class Executor
{
    public const ACTION_GET = 'get';
    public const ACTION_FIRST = 'first';
    public const ACTION_CREATE = 'create';
    public const ACTION_UPDATE = 'update';
    public const ACTION_DELETE = 'delete';

    /**
     * @var \Vollborn\LocalDB\Classes\Query
     */
    protected Query $query;

    /**
     * @param \Vollborn\LocalDB\Classes\Query $query
     */
    public function __construct(Query $query)
    {
        $this->query = $query;
    }

    /**
     * @param string $actionType
     * @return array
     * @throws \Vollborn\LocalDB\Classes\Exceptions\LocalDBException
     * @throws \Exception
     */
    public function execute(string $actionType): ?array
    {
        switch ($actionType) {
            case self::ACTION_GET:
                return $this->get();
            case self::ACTION_FIRST:
                return $this->first();
            case self::ACTION_CREATE:
                return $this->create();
            case self::ACTION_UPDATE:
                return $this->update();
            case self::ACTION_DELETE:
                return $this->delete();
        }

        throw new LocalDBException();
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function get(): array
    {
        $data = $this->query->getTable()->getWriter()->read();
        $data = $this->applyFilters($data);
        return Row::toArray($data);
    }

    /**
     * @return array|null
     * @throws \Exception
     */
    public function first(): ?array
    {
        $data = $this->query->getTable()->getWriter()->read();
        $data = $this->applyFilters($data);
        $array = Row::toArray($data);
        return $array[0] ?? null;
    }

    /**
     * @return array
     * @throws \Vollborn\LocalDB\Classes\Exceptions\LocalDBException
     * @throws \Exception
     */
    public function create(): array
    {
        $attributes = $this->query->getAttributes();
        $this->validateAttributes($attributes);

        $writer = $this->query->getTable()->getWriter();
        $data = $writer->read();
        $data[] = new Row($attributes);
        $writer->write($data);

        return $attributes;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function update(): array
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

    /**
     * @return array
     * @throws \Exception
     */
    public function delete(): array
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

    /**
     * @param array $data
     * @return array
     */
    protected function applyFilters(array $data): array
    {
        foreach ($this->query->getFilters() as $filter) {
            switch ($filter[1]) {
                case "=":
                    $data = array_filter($data, static function ($item) use ($filter) {
                        $array = $item->getAttributes();
                        return $array[$filter[0]] === $filter[2];
                    });
                    break;
                case "!=":
                case "<>":
                    $data = array_filter($data, static function ($item) use ($filter) {
                        $array = $item->getAttributes();
                        return $array[$filter[0]] !== $filter[2];
                    });
                    break;
            }
        }

        return $data;
    }

    /**
     * @param array $attributes
     * @return void
     * @throws \Vollborn\LocalDB\Classes\Exceptions\LocalDBException
     */
    protected function validateAttributes(array $attributes)
    {
        $columns = $this->query->getTable()->getColumns();
        if (!Validator::columns($columns, $attributes)) {
            throw new LocalDBException();
        }
    }
}
