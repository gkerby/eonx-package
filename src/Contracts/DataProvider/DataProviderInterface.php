<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\Contracts\DataProvider;

interface DataProviderInterface
{
    public function getCustomersList(?FetcherFilterInterface $filter = null): array;
}
