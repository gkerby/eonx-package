<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\DataProvider;

use Kerby\EonxTestTask\Contracts\DataProvider\CustomerValidatorInterface;
use Kerby\EonxTestTask\Contracts\Entity\CustomerDTOInterface;
use Kerby\EonxTestTask\Exception\InvalidRemoteCustomerDataException;

class GenericCustomerValidator implements CustomerValidatorInterface
{
    public function validate(CustomerDTOInterface $customer): void
    {
        if (empty($customer->getEmail())) {
            throw new InvalidRemoteCustomerDataException($customer, 'Email is empty');
        }

        if (empty($customer->getLastName())) {
            throw new InvalidRemoteCustomerDataException($customer, 'Last name is empty');
        }
    }
}
