<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\Contracts\DataProvider;

interface DataProviderFactoryInterface
{
    public function makeDataProvider(): DataProviderInterface;
}
