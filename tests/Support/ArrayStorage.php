<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\Tests\Support;

use Kerby\EonxTestTask\Contracts\Entity\CustomerDTOInterface;
use Kerby\EonxTestTask\Contracts\Storage\CustomerStorageInterface;

class ArrayStorage implements CustomerStorageInterface
{
    private array $storage = [];

    public function find($id): CustomerDTOInterface
    {
        return $this->storage[$id];
    }

    public function all(): array
    {
        return $this->storage;
    }

    public function store(CustomerDTOInterface $customer): void
    {
        $this->storage[$customer->getEmail()] = $customer;
    }
}
