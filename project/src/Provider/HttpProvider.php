<?php

declare(strict_types=1);

namespace App\Provider;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpProvider implements ProviderInterface
{
    public function __construct(
        public readonly HttpClientInterface $client,
        public readonly string $baseUrl,
        public readonly string $method = 'GET'
    )
    {
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function getOffer(): array
    {
        $response = $this->client->request(
            $this->method,
            $this->baseUrl
        );
        return $response->toArray();
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function addOrder(): array
    {
        $response = $this->client->request(
            $this->method,
            $this->baseUrl
        );
        return $response->toArray();
    }
}
