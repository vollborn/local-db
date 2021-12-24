<?php

namespace Vollborn\LocalDB\Classes\Validators;

class StringValidator extends BaseValidator
{
    public const TYPE = 'string';

    /**
     * @return bool
     */
    public function execute(): bool
    {
        return $this->validateType(static::TYPE);
    }
}
