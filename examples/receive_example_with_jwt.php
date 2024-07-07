<?php

declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use WebhookManager\Authentication\JwtAuthentication;
use WebhookManager\Events\WebhookEvent;
use WebhookManager\Handlers\JwtWebhookHandler;
use WebhookManager\Headers\WebhookHeaders;
use WebhookManager\Loggers\SimpleWebhookLogger;
use WebhookManager\Payloads\JsonWebhookPayload;
use WebhookManager\Policy\SimpleRetryPolicy;
use WebhookManager\Webhook\Webhook;
use WebhookManager\Webhook\WebhookClient;
use WebhookManager\Webhook\WebhookManager;

$secretKey      = 'mysecretkey';
$data           = [
    'key1' => 'value1',
    'key2' => 'value2',
    ];
$httpClient     = new Client();
$retryPolicy    = new SimpleRetryPolicy(3);
$client         = new WebhookClient($httpClient, $retryPolicy);
$authentication = new JwtAuthentication($secretKey);
$logger         = new SimpleWebhookLogger();
$manager        = new WebhookManager($client, $authentication, $logger);
$handler        = new JwtWebhookHandler($secretKey);

$token = JWT::encode(['data' => $data], $secretKey, 'HS256');

$headers = new WebhookHeaders([
    'Authorization' => "$token",
    'Content-Type'  => 'application/json',
]);

$payload = new JsonWebhookPayload($data);
$webhook = new Webhook('https://example.com', $headers, $payload);
$event   = new WebhookEvent('test_event', $webhook);

$manager->registerHandler('test_event', $handler);

try {
    $manager->triggerEvent($event);
} catch (Exception $e) {
    echo $e->getMessage();
}
