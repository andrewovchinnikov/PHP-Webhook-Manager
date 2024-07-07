<?php

declare(strict_types=1);

require_once __DIR__.'/vendor/autoload.php';

use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use WebhookManager\Authentication\IpAuthenticationInterface;
use WebhookManager\Events\WebhookEvent;
use WebhookManager\Handlers\JwtWebhookHandler;
use WebhookManager\Headers\WebhookHeaders;
use WebhookManager\Clients\AsyncWebhookClient;
use WebhookManager\Loggers\SimpleWebhookLogger;
use WebhookManager\Payloads\JsonWebhookPayload;
use WebhookManager\Policy\SimpleRetryPolicy;
use WebhookManager\Webhook\Webhook;
use WebhookManager\Webhook\WebhookManager;

$secretKey      = 'mysecretkey';
$data           = ['foo' => 'bar', 'baz' => ['qux' => 'quux']];
$httpClient     = new Client();
$retryPolicy    = new SimpleRetryPolicy(3);
$client         = new AsyncWebhookClient($httpClient, $retryPolicy);
$allowedIps     = ['127.0.0.1', '::1']; // разрешенные IP-адреса
$authentication = new IpAuthenticationInterface($allowedIps);
$logger         = new SimpleWebhookLogger();
$manager        = new WebhookManager($client, $authentication, $logger);
$handler        = new JwtWebhookHandler($secretKey);

// JSON payload
$jsonPayload = new JsonWebhookPayload($data);
$jsonHeaders = new WebhookHeaders([
    'Authorization' => 'Bearer '.JWT::encode(['data' => $data], $secretKey, 'HS256'),
    'Content-Type'  => 'application/json',
]);
$jsonWebhook = new Webhook('https://example.com', $jsonHeaders, $jsonPayload);
$jsonEvent   = new WebhookEvent('test_event', $jsonWebhook);
$manager->registerHandler('test_event', $handler);
$manager->triggerEvent($jsonEvent);
echo "JSON webhook delivered successfully with status code: ".$jsonEvent->getWebhook()->getResponseCode().PHP_EOL;
