<?php

declare(strict_types=1);

require_once __DIR__.'/vendor/autoload.php';

use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use WebhookManager\JwtAuthentication;
use WebhookManager\JwtWebhookHandler;
use WebhookManager\SimpleRetryPolicy;
use WebhookManager\SimpleWebhookLogger;
use WebhookManager\Webhook;
use WebhookManager\WebhookEvent;
use WebhookManager\WebhookManager;
use WebhookManager\WebhookClient;

$secretKey      = 'mysecretkey';
$data           = '{"foo":"bar"}';
$httpClient     = new Client();
$retryPolicy    = new SimpleRetryPolicy(3);
$client         = new WebhookClient($httpClient, $retryPolicy);
$authentication = new JwtAuthentication($secretKey);
$logger         = new SimpleWebhookLogger();
$manager        = new WebhookManager($client, $authentication, $logger);
$handler        = new JwtWebhookHandler($secretKey);

$token = JWT::encode(['data' => $data], $secretKey, 'HS256');

$webhook = new Webhook('https://example.com', [
    'Authorization' => "$token",
    'Content-Type'  => 'application/json',
], $data);
$event   = new WebhookEvent('test_event', $webhook);

$manager->registerHandler('test_event', $handler);

$manager->triggerEvent($event);

