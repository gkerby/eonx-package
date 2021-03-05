<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\Tests\Support;

use Kerby\EonxTestTask\Contracts\DataProvider\FetcherInterface;
use Kerby\EonxTestTask\Contracts\DataProvider\FetcherFilterInterface;

class ArrayFetcher implements FetcherInterface
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getCustomersList(?FetcherFilterInterface $filter = null): array
    {
        return $this->data;
    }
}
