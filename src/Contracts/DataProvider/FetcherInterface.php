<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\Contracts\DataProvider;

interface FetcherInterface
{
    /**
     * Returns array of customers data. Each of them are still an array, they will be later transformed into
     * Adapter entities by factory
     *
     * @param FetcherFilterInterface|null $filter
     * @return array
     */
    public function getCustomersList(?FetcherFilterInterface $filter = null): array;
}
