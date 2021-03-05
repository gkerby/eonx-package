<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\DataProvider\RandomUser;

use Kerby\EonxTestTask\Contracts\DataProvider\FetcherInterface;
use Kerby\EonxTestTask\Contracts\DataProvider\DataProviderInterface;
use Kerby\EonxTestTask\Contracts\DataProvider\DataProviderFactoryInterface;
use Kerby\EonxTestTask\Contracts\Entity\CustomerDTOFactoryInterface;
use Kerby\EonxTestTask\DataProvider\AbstractDataProviderFactory;

class RandomUserDataProviderFactory extends AbstractDataProviderFactory
{
    public function makeDataProvider(): DataProviderInterface
    {
        return new RandomUserDataProvider($this->fetcher, $this->factory);
    }
}
