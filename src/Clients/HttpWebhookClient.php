<?php

declare(strict_types=1);

namespace WebhookManager\Clients;

use exeption\WebhookDeliveryException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use WebhookManager\Webhook\Webhook;

/**
 * Class for sending webhooks using HTTP.
 */
class HttpWebhookClient implements WebhookClientInterface
{
    /**
     * HTTP client for sending webhooks.
     *
     * @var Client
     */
    private Client $httpClient;

    /**
     * Class constructor.
     *
     * @param Client $httpClient HTTP client for sending webhooks.
     */
    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Sends webhook and returns response.
     *
     * @param Webhook $webhook Webhook to send.
     *
     * @return ResponseInterface Response from webhook server.
     *
     * @throws WebhookDeliveryException|GuzzleException If failed to deliver webhook.
     */
    public function send(Webhook $webhook) : ResponseInterface
    {
        try {
            $response = $this->httpClient->request(
                'POST',
                $webhook->getUrl(),
                [
                    'headers' => $webhook->getHeaders(),
                    'body'    => $webhook->getPayload(),
                ]
            );

            $webhook->setResponseCode($response->getStatusCode());

            return $response;
        } catch (RequestException $e) {
            throw new WebhookDeliveryException('Failed to deliver webhook', $e->getCode(), $e);
        }
    }
}
