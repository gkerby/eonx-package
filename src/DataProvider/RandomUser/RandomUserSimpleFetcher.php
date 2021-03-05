<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\DataProvider\RandomUser;

use Kerby\EonxTestTask\Contracts\DataProvider\FetcherFilterInterface;
use Kerby\EonxTestTask\DataProvider\AbstractHttpApiFetcher;
use Kerby\EonxTestTask\Exception\RemoteApiErrorException;
use Kerby\EonxTestTask\Exception\UnexpectedRemoteCustomerDataException;

class RandomUserSimpleFetcher extends AbstractHttpApiFetcher
{
    /**
     * This is just a sample method to fetch data via file_get_contents
     *
     * It will be overridden within Lumen or Symfony to use appropriate approach
     *
     * @param string $baseUri
     * @param array $params
     * @return string
     */
    protected function getApiTextResponse(string $baseUri, array $params = []): string
    {
        return file_get_contents($baseUri . (empty($params) ? '' : '?' . http_build_query($params)));
    }

    /**
     * Build query params specifically for https://randomuser.me/api
     *
     * @param FetcherFilterInterface|null $filter
     * @return array
     */
    protected function buildQueryParams(?FetcherFilterInterface $filter): array
    {
        if ($filter === null) {
            return [];
        }

        $query = [];

        if ($filter->getResultsNumber()) {
            $query['results'] = $filter->getResultsNumber();
        }

        if ($filter->getNationality()) {
            $query['nat'] = $filter->getNationality();
        }

        return $query;
    }

    /**
     * Just a simple validation that we have results and they are actually array
     *
     * @param array $data
     * @throws RemoteApiErrorException
     * @throws UnexpectedRemoteCustomerDataException
     */
    protected function validateIncomingData(array $data): void
    {
        if (isset($data['error'])) {
            throw new RemoteApiErrorException($data['error']);
        }

        if (!isset($data['results'])) {
            throw new UnexpectedRemoteCustomerDataException('There is no results key in API response data');
        }

        if (!is_array($data['results'])) {
            throw new UnexpectedRemoteCustomerDataException('Results data is not an array in API response data');
        }
    }

    /**
     * Get rid of results wrapper
     *
     * @param array $data
     * @return array
     */
    protected function transformResult(array $data): array
    {
        return $data['results'];
    }

    /**
     * Return actual URI to fetch customers
     *
     * @return string
     */
    protected function getBaseUri(): string
    {
        return 'https://randomuser.me/api';
    }
}
