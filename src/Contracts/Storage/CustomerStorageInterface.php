<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\Contracts\Storage;

use Kerby\EonxTestTask\Contracts\Entity\CustomerDTOInterface;

interface CustomerStorageInterface
{
    public function store(CustomerDTOInterface $customer): void;
}
