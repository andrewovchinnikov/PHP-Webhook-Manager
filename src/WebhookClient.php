<?php

namespace WebhookManager;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class WebhookClient implements WebhookClientInterface
{
    private Client             $httpClient;
    private WebhookRetryPolicy $retryPolicy;

    public function __construct(Client $httpClient, WebhookRetryPolicy $retryPolicy)
    {
        $this->httpClient  = $httpClient;
        $this->retryPolicy = $retryPolicy;
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function send(Webhook $webhook) : \Psr\Http\Message\ResponseInterface
    {
        $attempts = $webhook->getAttempts();

        try {
            $response = $this->httpClient->request(
                'POST',
                $webhook->getUrl(),
                [
                    'headers' => $webhook->getHeaders(),
                    'body'    => $webhook->getPayload(),
                ]
            );

            $webhook->setResponse($response->getStatusCode(), $response->getBody()->getContents());
            $webhook->setAttempts($attempts + 1);

            return $response;

        } catch (Exception $exception) {
            if (!$this->retryPolicy->shouldRetry($webhook, $exception)) {
                throw $exception;
            }

            usleep(100000); // Wait for 100ms before retrying

            // Recursively call the 'send' method with the updated webhook object
            return $this->send($webhook);
        }
    }
}
