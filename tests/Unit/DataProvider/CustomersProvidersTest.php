<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\Tests\Unit\DataProvider;

use JsonException;
use Kerby\EonxTestTask\Contracts\DataProvider\DataProviderFactoryInterface;
use Kerby\EonxTestTask\Contracts\DataProvider\FetcherInterface;
use Kerby\EonxTestTask\Contracts\Entity\CustomerDTOFactoryInterface;
use Kerby\EonxTestTask\Contracts\Entity\CustomerDTOInterface;
use Kerby\EonxTestTask\DataProvider\GenericCustomerValidator;
use Kerby\EonxTestTask\DataProvider\GenericFetcherFilter;
use Kerby\EonxTestTask\DataProvider\RandomUser\RandomUserCustomerDTOFactory;
use Kerby\EonxTestTask\DataProvider\RandomUser\RandomUserDataProviderFactory;
use Kerby\EonxTestTask\Tests\Support\ArrayFetcher;
use Kerby\EonxTestTask\Tests\TestCase;
use Kerby\EonxTestTask\Tests\Unit\DataProvider\RandomUser\RandomUserComparer;

class CustomersProvidersTest extends TestCase
{
    /**
     * Static props to hold immutable sample data between tests
     */
    protected static array $sampleList = [];
    protected static array $sampleItem = [];

    /**
     * @throws JsonException
     */
    public static function setUpBeforeClass(): void
    {
        self::$sampleList[RandomUserDataProviderFactory::class] = json_decode(
            file_get_contents(__DIR__ . '/RandomUser/data/sampleDataList.json'),
            true,
            512,
            JSON_THROW_ON_ERROR
        )['results'];

        self::$sampleItem[RandomUserDataProviderFactory::class] = json_decode(
            file_get_contents(__DIR__ . '/RandomUser/data/sampleDataItem.json'),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }

    /**
     * @dataProvider dataProvider
     * @param string $testFactoryClass
     */
    public function testItCreatesCorrectNumberOfCustomers(string $testFactoryClass): void
    {
        /** @var DataProviderFactoryInterface $testingFactory */
        $testingFactory = new $testFactoryClass(new ArrayFetcher(self::$sampleList[$testFactoryClass]), $this->makeDefaultCustomerFactory());

        $result = $testingFactory->makeDataProvider()->getCustomersList();

        self::assertCount(count(self::$sampleList[$testFactoryClass]), $result);
    }

    protected function makeDefaultCustomerFactory(): CustomerDTOFactoryInterface
    {
        return new RandomUserCustomerDTOFactory(new GenericCustomerValidator());
    }

    /**
     * @dataProvider dataProvider
     * @param string $testFactoryClass
     * @param string $comparerClass
     */
    public function testItReturnsCorrectData(string $testFactoryClass, string $comparerClass): void
    {
        /** @var DataProviderFactoryInterface $testingFactory */
        $testingFactory = new $testFactoryClass(new ArrayFetcher([self::$sampleItem[$testFactoryClass]]), $this->makeDefaultCustomerFactory());

        $result = $testingFactory->makeDataProvider()->getCustomersList();

        self::assertCount(1, $result);

        /** @var CustomerDTOInterface $customer */
        $customer = reset($result);

        /**
         * and same data
         * @var CustomerDataComparerInterface $comparer
         */
        $comparer = new $comparerClass();
        $comparer->compareCustomerData($this, self::$sampleItem[$testFactoryClass], $customer);
    }

    /**
     * @dataProvider dataProvider
     * @param string $testFactoryClass
     */
    public function testProviderPassesCorrectFilterToFetcher(string $testFactoryClass): void
    {
        $fetcherMock = $this->createMock(FetcherInterface::class);

        $filter = new GenericFetcherFilter();
        $filter->setResultsNumber(10)->setNationality('ru');

        $fetcherMock->expects(self::once())
            ->method('getCustomersList')
            ->with(
                self::identicalTo($filter)
            );

        /** @var DataProviderFactoryInterface $testingFactory */
        $testingFactory = new $testFactoryClass($fetcherMock, $this->makeDefaultCustomerFactory());

        $testingFactory
            ->makeDataProvider()
            ->getCustomersList($filter);
    }

    public function dataProvider(): array
    {
        return [
            RandomUserDataProviderFactory::class => [RandomUserDataProviderFactory::class, RandomUserComparer::class]
        ];
    }
}
