<?php

namespace WebhookManager;

use GuzzleHttp\Client;

class WebhookClient
{
    private Client $httpClient;
    private WebhookRetryPolicy $retryPolicy;

    public function __construct(Client $httpClient, WebhookRetryPolicy $retryPolicy)
    {
        $this->httpClient = $httpClient;
        $this->retryPolicy = $retryPolicy;
    }

    public function send(Webhook $webhook): void
    {
        $attempts = $webhook->getAttempts();

        try {
            $response = $this->httpClient->request(
                'POST',
                $webhook->getUrl(),
                [
                    'headers' => $webhook->getHeaders(),
                    'body' => $webhook->getPayload(),
                ]
            );

            $webhook->setResponse($response->getStatusCode(), $response->getBody()->getContents());
            $webhook->setAttempts($attempts + 1);

        } catch (\Exception $exception) {
            if (!$this->retryPolicy->shouldRetry($webhook, $exception)) {
                throw $exception;
            }

            usleep(100000); // Wait for 100ms before retrying
            $this->send($webhook);
        }
    }
}
