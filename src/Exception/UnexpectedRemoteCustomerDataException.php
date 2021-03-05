<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\Exception;

use Exception;
use Throwable;

class UnexpectedRemoteCustomerDataException extends Exception
{
    public function __construct($message = 'Unexpected remote customer data', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
