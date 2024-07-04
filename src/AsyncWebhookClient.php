<?php

declare(strict_types=1);

namespace WebhookManager;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class AsyncWebhookClient implements WebhookClientInterface
{
    private ClientInterface $httpClient;

    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function send(Webhook $webhook): ResponseInterface
    {
        $promise = $this->httpClient->requestAsync(
            'POST',
            $webhook->getUrl(),
            [
                'headers' => $webhook->getHeaders(),
                'body' => (string) $webhook->getPayload(),
            ]
        );

        return $promise->wait();
    }
}


