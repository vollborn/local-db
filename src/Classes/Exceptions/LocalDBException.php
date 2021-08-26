<?php

namespace LocalDB\Classes\Exceptions;

use Exception;
use Throwable;

class LocalDBException extends Exception
{
    private string $prefix = 'LocalDB: ';

    /**
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($this->prefix . $message, $code, $previous);
    }
}
