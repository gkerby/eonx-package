<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\DataProvider;

use Kerby\EonxTestTask\Contracts\DataProvider\FetcherInterface;
use Kerby\EonxTestTask\Contracts\DataProvider\FetcherFilterInterface;
use Kerby\EonxTestTask\Contracts\DataProvider\DataProviderInterface;
use Kerby\EonxTestTask\Contracts\Entity\CustomerDTOFactoryInterface;

class GenericDataProvider implements DataProviderInterface
{
    private FetcherInterface $fetcher;
    private CustomerDTOFactoryInterface $customerFactory;

    public function __construct(FetcherInterface $fetcher, CustomerDTOFactoryInterface $customerFactory)
    {
        $this->fetcher = $fetcher;
        $this->customerFactory = $customerFactory;
    }

    public function getCustomersList(?FetcherFilterInterface $filter = null): array
    {
        $apiResult = $this->fetcher->getCustomersList($filter);

        return $this->buildFromFetchedArray($apiResult);
    }

    protected function buildFromFetchedArray(array $apiResult): array
    {
        $result = [];

        foreach ($apiResult as $data) {
            $result[] = $this->customerFactory->make($data);
        }

        return $result;
    }
}
