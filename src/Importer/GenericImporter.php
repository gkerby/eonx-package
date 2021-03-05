<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\Importer;

use Kerby\EonxTestTask\Contracts\DataProvider\DataProviderInterface;
use Kerby\EonxTestTask\Contracts\DataProvider\FetcherFilterInterface;
use Kerby\EonxTestTask\Contracts\Importer\ImporterInterface;
use Kerby\EonxTestTask\Contracts\Storage\CustomerStorageInterface;

class GenericImporter implements ImporterInterface
{
    private CustomerStorageInterface $storage;
    private DataProviderInterface $customersProvider;

    public function __construct(DataProviderInterface $customersProvider, CustomerStorageInterface $storage)
    {
        $this->storage = $storage;
        $this->customersProvider = $customersProvider;
    }

    public function import(?FetcherFilterInterface $filter = null): void
    {
        foreach ($this->customersProvider->getCustomersList($filter) as $customer) {
            $this->storage->store($customer);
        }
    }
}
