<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\Tests\Unit\DataProvider\RandomUser\Fetcher;

use Kerby\EonxTestTask\Contracts\DataProvider\FetcherFilterInterface;
use Kerby\EonxTestTask\DataProvider\GenericFetcherFilter;
use Kerby\EonxTestTask\DataProvider\RandomUser\RandomUserSimpleFetcher;
use Kerby\EonxTestTask\Exception\RemoteApiErrorException;
use Kerby\EonxTestTask\Exception\UnexpectedRemoteCustomerDataException;
use Kerby\EonxTestTask\Tests\TestCase;

class RandomUserSimpleFetcherTest extends TestCase
{
    protected static string $correctResults;

    private const API_RESPONSE_EMPTY = '';
    private const API_RESPONSE_EMPTY_OBJECT = '{}';
    private const API_RESPONSE_RESULTS_IS_NOT_ARRAY = '{"results":123}';
    private const API_RESPONSE_RESULTS_IS_EMPTY_LIST = '{"results":[]}';
    private const API_RESPONSE_ERROR = '{"error":"There is error"}';

    public static function setUpBeforeClass(): void
    {
        self::$correctResults = file_get_contents(__DIR__ . '/../data/sampleDataList.json');
    }

    /**
     * @param string $returnedResult
     * @return RandomUserSimpleFetcher|\PHPUnit\Framework\MockObject\MockObject
     */
    private function createFetcherMockWithApiResult(string $returnedResult)
    {
        $fetcher = $this->createPartialMock(RandomUserSimpleFetcher::class, ['getApiTextResponse']);
        $fetcher->method('getApiTextResponse')->willReturn($returnedResult);
        return $fetcher;
    }

    public function testItFailsWhenRemoteApiReturnError(): void
    {
        $this->expectException(RemoteApiErrorException::class);

        $fetcher = $this->createFetcherMockWithApiResult(self::API_RESPONSE_ERROR);

        /** @noinspection UnusedFunctionResultInspection */
        $fetcher->getCustomersList();
    }

    public function testItFailsWhenEmptyResponseIsReceived(): void
    {
        $this->expectException(UnexpectedRemoteCustomerDataException::class);

        $fetcher = $this->createFetcherMockWithApiResult(self::API_RESPONSE_EMPTY);

        /** @noinspection UnusedFunctionResultInspection */
        $fetcher->getCustomersList();
    }

    public function testItFailsWhenInvalidDataIsGiven(): void
    {
        $this->expectException(UnexpectedRemoteCustomerDataException::class);

        $fetcher = $this->createFetcherMockWithApiResult(self::API_RESPONSE_EMPTY_OBJECT);

        /** @noinspection UnusedFunctionResultInspection */
        $fetcher->getCustomersList();
    }

    public function testItFailsWhenResultIsNotAnArray(): void
    {
        $this->expectException(UnexpectedRemoteCustomerDataException::class);

        $fetcher = $this->createFetcherMockWithApiResult(self::API_RESPONSE_RESULTS_IS_NOT_ARRAY);

        /** @noinspection UnusedFunctionResultInspection */
        $fetcher->getCustomersList();
    }

    public function testItReturnsEmptyArrayWhenSourceDataHasNoResults(): void
    {
        $fetcher = $this->createFetcherMockWithApiResult(self::API_RESPONSE_RESULTS_IS_EMPTY_LIST);

        self::assertEmpty($fetcher->getCustomersList());
    }

    public function testItReturnsCorrectArrayCountWhenResultIsNormal(): void
    {
        $fetcher = $this->createFetcherMockWithApiResult(self::$correctResults);

        self::assertCount(100, $fetcher->getCustomersList());
    }

    private function checkQueryParamsWithFilter(?FetcherFilterInterface $filter, array $expectedParams = []): void
    {
        $fetcher = $this->createPartialMock(RandomUserSimpleFetcher::class, ['getApiTextResponse']);

        $fetcher->expects(self::once())
            ->method('getApiTextResponse')
            ->with('https://randomuser.me/api', $expectedParams)
            ->willReturn(self::API_RESPONSE_RESULTS_IS_EMPTY_LIST);

        /** @noinspection UnusedFunctionResultInspection */
        $fetcher->getCustomersList($filter);
    }

    public function testItBuildCorrectQueryStringWhenFilterIsEmpty(): void
    {
        $this->checkQueryParamsWithFilter(null, []);
    }

    public function testItBuildCorrectQueryStringWithDefaultFilter(): void
    {
        $filter = new GenericFetcherFilter();
        $this->checkQueryParamsWithFilter($filter, ['results' => 100, 'nat' => 'au']);
    }

    public function testItBuildCorrectQueryStringWithOnlyResultsNumber(): void
    {
        $filter = new GenericFetcherFilter();
        $filter
            ->setResultsNumber(10)
            ->setNationality(null);

        $this->checkQueryParamsWithFilter($filter, ['results' => 10]);
    }

    public function testItBuildCorrectQueryStringWithOnlyNationallity(): void
    {
        $filter = new GenericFetcherFilter();
        $filter
            ->setResultsNumber(null)
            ->setNationality('fr');

        $this->checkQueryParamsWithFilter($filter, ['nat' => 'fr']);
    }

    public function testItTakesDataFromFileSystem(): void
    {
        $fetcher = $this->createPartialMock(RandomUserSimpleFetcher::class, ['getBaseUri']);

        $fetcher->method('getBaseUri')->willReturn(__DIR__ . '/../data/sampleDataList.json');

        /** @noinspection UnusedFunctionResultInspection */
        self::assertCount(100, $fetcher->getCustomersList());
    }
}
