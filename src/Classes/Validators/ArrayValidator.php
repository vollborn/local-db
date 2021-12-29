<?php

namespace Vollborn\LocalDB\Classes\Validators;

class ArrayValidator extends BaseValidator
{
    public const TYPE = 'array';

    /**
     * @return bool
     */
    public function execute(): bool
    {
        return $this->validateType(static::TYPE);
    }
}
