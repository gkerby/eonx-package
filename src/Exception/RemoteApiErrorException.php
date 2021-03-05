<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\Exception;

use Exception;
use Throwable;

class RemoteApiErrorException extends Exception
{
    public function __construct($message = 'Remote API error', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
