<?php

namespace Vollborn\LocalDB\Classes\Validators;

class IntValidator extends BaseValidator
{
    public const TYPE = 'integer';

    /**
     * @return bool
     */
    public function execute(): bool
    {
        return $this->validateType(static::TYPE);
    }
}
