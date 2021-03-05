<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\Contracts\Entity;

interface CustomerDTOFactoryInterface
{
    public function make(array $data): CustomerDTOInterface;
}
