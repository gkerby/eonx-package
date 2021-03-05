<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\Contracts\DataProvider;

use Kerby\EonxTestTask\Contracts\Entity\CustomerDTOInterface;

interface CustomerValidatorInterface
{
    public function validate(CustomerDTOInterface $customer): void;
}
