<?php

namespace WebhookManager\Webhook;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use WebhookManager\Clients\WebhookClientInterface;
use WebhookManager\Policy\WebhookRetryPolicyInterface;

class WebhookClient implements WebhookClientInterface
{
    private Client                      $httpClient;
    private WebhookRetryPolicyInterface $retryPolicy;

    public function __construct(Client $httpClient, WebhookRetryPolicyInterface $retryPolicy)
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
                    'headers' => $webhook->getHeaders()->getHeaders(),
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

            usleep(10000); // Wait for 10ms before retrying

            // Recursively call the 'send' method with the updated webhook object
            return $this->send($webhook);
        }
    }
}
