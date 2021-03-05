<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\DataProvider\RandomUser;

use Kerby\EonxTestTask\Contracts\DataProvider\CustomerValidatorInterface;
use Kerby\EonxTestTask\Contracts\Entity\CustomerDTOFactoryInterface;
use Kerby\EonxTestTask\Contracts\Entity\CustomerDTOInterface;
use Kerby\EonxTestTask\Entity\CustomerDTO;

class RandomUserCustomerDTOFactory implements CustomerDTOFactoryInterface
{
    private CustomerValidatorInterface $validator;

    public function __construct(CustomerValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function make(array $data): CustomerDTOInterface
    {
        $customer = new CustomerDTO();

        $customer
            ->setFirstName($data['name']['first'] ?? null)
            ->setLastName($data['name']['last'] ?? null)
            ->setEmail($data['email'] ?? null)
            ->setCountry($data['location']['country'] ?? null)
            ->setCity($data['location']['city'] ?? null)
            ->setGender($data['gender'] ?? null)
            ->setUsername($data['login']['username'] ?? null)
            ->setPhone($data['phone'] ?? null);

        $this->validator->validate($customer);

        return $customer;
    }
}
