<?php

namespace Vollborn\LocalDB\Classes\Validators;

class FloatValidator extends BaseValidator
{
    public const TYPE_FLOAT = 'double';
    public const TYPE_INT = 'integer';

    /**
     * @return bool
     */
    public function execute(): bool
    {
        return $this->validateType(static::TYPE_FLOAT) || $this->validateType(static::TYPE_INT);
    }
}
