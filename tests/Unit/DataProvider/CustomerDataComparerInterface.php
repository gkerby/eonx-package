<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\Tests\Unit\DataProvider;

use Kerby\EonxTestTask\Contracts\Entity\CustomerDTOInterface;
use Kerby\EonxTestTask\Tests\TestCase;

interface CustomerDataComparerInterface
{
    public function compareCustomerData(TestCase $testCase, array $sampleItem, CustomerDTOInterface $customer): void;
}
