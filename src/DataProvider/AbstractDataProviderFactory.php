<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\DataProvider;

use Kerby\EonxTestTask\Contracts\DataProvider\FetcherInterface;
use Kerby\EonxTestTask\Contracts\DataProvider\DataProviderInterface;
use Kerby\EonxTestTask\Contracts\DataProvider\DataProviderFactoryInterface;
use Kerby\EonxTestTask\Contracts\Entity\CustomerDTOFactoryInterface;
use Kerby\EonxTestTask\DataProvider\RandomUser\RandomUserDataProvider;

abstract class AbstractDataProviderFactory implements DataProviderFactoryInterface
{
    protected FetcherInterface $fetcher;
    protected CustomerDTOFactoryInterface $factory;

    public function __construct(FetcherInterface $fetcher, CustomerDTOFactoryInterface $factory)
    {
        $this->fetcher = $fetcher;
        $this->factory = $factory;
    }

    abstract public function makeDataProvider(): DataProviderInterface;
}
