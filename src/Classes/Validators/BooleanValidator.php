<?php

namespace Vollborn\LocalDB\Classes\Validators;

class BooleanValidator extends BaseValidator
{
    public const TYPE = 'boolean';

    /**
     * @return bool
     */
    public function execute(): bool
    {
        return $this->validateType(static::TYPE);
    }
}
