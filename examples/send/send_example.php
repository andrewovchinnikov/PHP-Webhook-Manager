<?php

declare(strict_types=1);

namespace WebhookManager;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use WebhookManager\Headers\WebhookHeaders;
use WebhookManager\Payloads\FormUrlEncodedWebhookPayload;
use WebhookManager\Payloads\JsonWebhookPayload;
use WebhookManager\Payloads\TextWebhookPayload;
use WebhookManager\Policy\SimpleRetryPolicy;
use WebhookManager\Webhook\Webhook;
use WebhookManager\Webhook\WebhookClient;

require_once __DIR__.'/../.././vendor/autoload.php';

// Create a new HTTP client
$httpClient = new Client();

// Create a new retry policy that retries up to 3 times
$retryPolicy = new SimpleRetryPolicy(3);

// Create a new webhook client
$webhookClient = new WebhookClient($httpClient, $retryPolicy);

// Create a new JSON payload
$jsonPayload = new JsonWebhookPayload([
    'key1' => 'value1',
    'key2' => 'value2',
]);

// Create a new text payload
$textPayload = new TextWebhookPayload(
    'Hello, World!'
);

// Create a new form-url-encoded payload
$formUrlEncodedPayload = new FormUrlEncodedWebhookPayload(
    ['key1=value1&key2=value2']
);

$webhookUrl = 'https://webhook.site/6acc75e2-0b38-4c87-b41a-3e8ab63cdd0d';

$headers    = new WebhookHeaders([
    'Content-Type' => 'application/json',
]);

$webhooks = [
    // Create a new webhook object
    new Webhook($webhookUrl, $headers, $jsonPayload),
    new Webhook($webhookUrl, $headers, $textPayload),
    new Webhook($webhookUrl, $headers, $formUrlEncodedPayload),
];

foreach ($webhooks as $webhook) {
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
}
