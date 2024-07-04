<?php

declare(strict_types=1);

namespace WebhookManager;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

class HttpWebhookClient implements WebhookClientInterface
{
    private Client $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function send(Webhook $webhook) : ResponseInterface
    {
        try {
            $response = $this->httpClient->request(
                'POST',
                $webhook->getUrl(),
                [
                    'headers' => $webhook->getHeaders(),
                    'body'    => (string)$webhook->getPayload(),
                ]
            );

            $webhook->setResponseCode($response->getStatusCode());

            return $response;
        } catch (RequestException $e) {
            throw new WebhookDeliveryException('Failed to deliver webhook', $e->getCode(), $e);
        }
    }
}
