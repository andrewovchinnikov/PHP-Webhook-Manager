<?php

declare(strict_types=1);

require_once __DIR__.'/vendor/autoload.php';

use GuzzleHttp\Client;
use WebhookManager\ExampleWebhookHandler;
use WebhookManager\SimpleRetryPolicy;
use WebhookManager\Webhook;
use WebhookManager\WebhookEvent;
use WebhookManager\WebhookManager;
use WebhookManager\WebhookClient;
use WebhookManager\SecretKeyAuthentication;

$secretKey      = 'my-secret-key';
$data           = '{"foo":"bar"}';
$httpClient     = new Client();
$retryPolicy    = new SimpleRetryPolicy(3);
$client         = new WebhookClient($httpClient , $retryPolicy);
$authentication = new SecretKeyAuthentication($secretKey);
$manager        = new WebhookManager($client, $authentication);
$handler        = new ExampleWebhookHandler();

$webhook = new Webhook('https://example.com', [
    'X-Signature'  => hash_hmac('sha256', $data, $secretKey),
    'Content-Type' => 'application/json',
], $data);
$event   = new WebhookEvent('test_event', $webhook);

$manager->registerHandler('test_event', $handler);

$manager->triggerEvent($event);
