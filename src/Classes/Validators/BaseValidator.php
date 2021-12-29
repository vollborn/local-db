<?php /** @noinspection PhpMissingFieldTypeInspection */

namespace Vollborn\LocalDB\Classes\Validators;

use Vollborn\LocalDB\Classes\Column;

abstract class BaseValidator
{
    protected Column $column;
    protected $value;

    /**
     * @param \Vollborn\LocalDB\Classes\Column $column
     * @param $value
     * @return bool
     */
    public static function call(Column $column, $value): bool
    {
        $called = get_called_class();
        return (new $called($column, $value))->execute();
    }

    /**
     * @param \Vollborn\LocalDB\Classes\Column $column
     * @param $value
     */
    public function __construct(Column $column, $value)
    {
        $this->column = $column;
        $this->value = $value;
    }

    /**
     * @return bool
     */
    abstract public function execute(): bool;

    /**
     * @param string $typeName
     * @return bool
     */
    protected function validateType(string $typeName): bool
    {
        $nullable = !$this->column->getNullable();
        $type = gettype($this->value);

        // if not nullable
        if (!$nullable && $type !== $typeName) {
            return false;
        }

        // if nullable
        if ($nullable && $type !== $typeName && $type !== 'NULL') {
            return false;
        }

        return true;
    }
}
