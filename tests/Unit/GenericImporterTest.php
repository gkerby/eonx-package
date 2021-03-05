<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\Tests\Unit;

use Kerby\EonxTestTask\Contracts\DataProvider\DataProviderInterface;
use Kerby\EonxTestTask\Contracts\Storage\CustomerStorageInterface;
use Kerby\EonxTestTask\DataProvider\GenericFetcherFilter;
use Kerby\EonxTestTask\Entity\CustomerDTO;
use Kerby\EonxTestTask\Importer\GenericImporter;
use Kerby\EonxTestTask\Tests\TestCase;

class GenericImporterTest extends TestCase
{
    public function testItStoresCorrectNumberOfEntities(): void
    {
        $entities = array_fill(0, 10, new CustomerDTO());

        $provider = $this->createStub(DataProviderInterface::class);
        $provider
            ->method('getCustomersList')
            ->willReturn($entities);

        $storage = $this->createMock(CustomerStorageInterface::class);
        $storage
            ->expects(self::exactly(count($entities)))
            ->method('store');

        $importer = new GenericImporter($provider, $storage);

        $importer->import(new GenericFetcherFilter());
    }
}
