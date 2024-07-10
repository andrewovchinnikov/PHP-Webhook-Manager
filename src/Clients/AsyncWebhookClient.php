<?php

declare(strict_types=1);

namespace WebhookManager\Clients;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use WebhookManager\Webhook\Webhook;

/**
 * Client for asynchronous sending webhooks using GuzzleHttp library.
 */
class AsyncWebhookClient implements WebhookClientInterface
{
    /**
     * GuzzleHttp client for sending HTTP requests.
     *
     * @var ClientInterface
     */
    private ClientInterface $httpClient;

    /**
     * Class constructor.
     *
     * @param ClientInterface $httpClient GuzzleHttp client for sending HTTP requests.
     */
    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Sends webhook to specified URL using POST method.
     *
     * @param Webhook $webhook Webhook object containing URL, headers and request body.
     *
     * @return ResponseInterface Server response to the request.
     */
    public function send(Webhook $webhook) : ResponseInterface
    {
        $promise = $this->httpClient->requestAsync(
            'POST',
            $webhook->getUrl(),
            [
                'headers' => $webhook->getHeaders()->getHeaders(),
                'body'    => $webhook->getPayload(),
            ]
        );

        return $promise->wait();
    }
}
