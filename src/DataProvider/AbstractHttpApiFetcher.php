<?php

declare(strict_types=1);

namespace Kerby\EonxTestTask\DataProvider;

use Exception;
use Kerby\EonxTestTask\Contracts\DataProvider\FetcherInterface;
use Kerby\EonxTestTask\Contracts\DataProvider\FetcherFilterInterface;
use Kerby\EonxTestTask\Exception\UnexpectedRemoteCustomerDataException;

/**
 * Class AbstractApiFetcher
 * @package Kerby\EonxTestTask\DataProvider
 *
 * Abstract class for fetching customers list data from remote HTTP API
 *
 * In real world it should probably use composition for real HTTP requests and parameters builder for filter,
 * but that's too much of abstraction for a test task to my taste.
 *
 * And, actually, in real world it is also a disputable topic for how much abstraction could be needed
 *
 * So... method template will do the trick
 */
abstract class AbstractHttpApiFetcher implements FetcherInterface
{
    public function getCustomersList(?FetcherFilterInterface $filter = null): array
    {
        $apiResponseText = $this->getApiTextResponse($this->getBaseUri(), $this->buildQueryParams($filter));

        $data = $this->transformApiResponse($apiResponseText);

        $this->validateIncomingData($data);

        return $this->transformResult($data);
    }

    /**
     * Returns base URI for API request
     *
     * @return string
     */
    abstract protected function getBaseUri(): string;

    /**
     * Returns remote API response in text
     *
     * @param string $baseUri
     * @param array $params - query params
     * @return string
     */
    abstract protected function getApiTextResponse(string $baseUri, array $params = []): string;

    /**
     * Builds array of http query params according to given filter
     *
     * @param FetcherFilterInterface|null $filter
     * @return array
     */
    abstract protected function buildQueryParams(?FetcherFilterInterface $filter): array;

    /**
     * Transforms text API response into associative array and can do other fancy stuff
     *
     * @param string $apiResponseText
     * @return array
     * @throws UnexpectedRemoteCustomerDataException
     */
    protected function transformApiResponse(string $apiResponseText): array
    {
        try {
            $data = json_decode(
                $apiResponseText,
                true,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (Exception $exception) {
            throw new UnexpectedRemoteCustomerDataException($exception->getMessage());
        }

        return $data;
    }

    /**
     * Performs validation of received data
     *
     * @param array $data
     * @throws UnexpectedRemoteCustomerDataException
     */
    abstract protected function validateIncomingData(array $data): void;

    /**
     * Can make manipulation with result array just before returning it from getCustomersList
     *
     * @param array $data
     * @return array
     */
    abstract protected function transformResult(array $data): array;
}
