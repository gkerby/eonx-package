<?php
declare(strict_types=1);

namespace Kerby\EonxTestTask\Tests\Unit\DataProvider\RandomUser;

use Kerby\EonxTestTask\Contracts\Entity\CustomerDTOInterface;
use Kerby\EonxTestTask\Tests\TestCase;
use Kerby\EonxTestTask\Tests\Unit\DataProvider\CustomerDataComparerInterface;

class RandomUserComparer implements CustomerDataComparerInterface
{
    public function compareCustomerData(TestCase $testCase, array $sampleItem, CustomerDTOInterface $customer): void
    {
        $testCase->assertEquals($sampleItem['name']['first'] ?? null, $customer->getFirstName());
        $testCase->assertEquals($sampleItem['name']['last'] ?? null, $customer->getLastName());
        $testCase->assertEquals($sampleItem['email'] ?? null, $customer->getEmail());
        $testCase->assertEquals($sampleItem['location']['country'] ?? null, $customer->getCountry());
        $testCase->assertEquals($sampleItem['location']['city'] ?? null, $customer->getCity());
        $testCase->assertEquals($sampleItem['gender'] ?? null, $customer->getGender());
        $testCase->assertEquals($sampleItem['login']['username'] ?? null, $customer->getUsername());
        $testCase->assertEquals($sampleItem['phone'] ?? null, $customer->getPhone());
    }
}
