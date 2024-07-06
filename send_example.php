<?php

declare(strict_types=1);

namespace WebhookManager;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use WebhookManager\Payload\JsonWebhookPayload;

require __DIR__.'/vendor/autoload.php';

// Create a new HTTP client
$httpClient = new Client();

// Create a new retry policy that retries up to 3 times
$retryPolicy = new SimpleRetryPolicy(3);

// Create a new webhook client
$webhookClient = new WebhookClient($httpClient, $retryPolicy);

$payload = new JsonWebhookPayload([
    'key1' => 'value1',
    'key2' => 'value2',
]);

// Create a new webhook object
$webhook = new Webhook(
    'https://webhook.site/6acc75e2-0b38-4c87-b41a-3e8ab63cdd0d',
    new WebhookHeaders([
        'Content-Type' => 'application/json',
    ]),
    $payload
);

try {
    // Send the webhook
    $response = $webhookClient->send($webhook);

    // Print the response status code and body
    echo 'Response status code: '.$response->getStatusCode().PHP_EOL;
    echo 'Response body: '.$response->getBody()->getContents().PHP_EOL;

} catch (GuzzleException $exception) {
    // Print the error message
    echo 'Error: '.$exception->getMessage().PHP_EOL;
}
