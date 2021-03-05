<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\Exception;

use Exception;
use Kerby\EonxTestTask\Contracts\Entity\CustomerDTOInterface;
use Throwable;

class InvalidRemoteCustomerDataException extends Exception
{
    private CustomerDTOInterface $customer;

    public function __construct(CustomerDTOInterface $customer, $message = 'Invalid remote customer data', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->customer = $customer;
    }

    public function getCustomer(): CustomerDTOInterface
    {
        return $this->customer;
    }
}
