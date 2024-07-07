<?php

declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

use GuzzleHttp\Client;
use WebhookManager\Authentication\IpAuthentication;
use WebhookManager\Events\WebhookEvent;
use WebhookManager\Handlers\JwtWebhookHandler;
use WebhookManager\Headers\WebhookHeaders;
use WebhookManager\Clients\AsyncWebhookClient;
use WebhookManager\Loggers\SimpleWebhookLogger;
use WebhookManager\Payloads\FormUrlEncodedWebhookPayload;
use WebhookManager\Payloads\TextWebhookPayload;
use WebhookManager\Policy\SimpleRetryPolicy;
use WebhookManager\Webhook\Webhook;
use WebhookManager\Webhook\WebhookManager;

$secretKey      = 'mysecretkey';
$data           = ['foo' => 'bar', 'baz' => ['qux' => 'quux']];
$httpClient     = new Client();
$retryPolicy    = new SimpleRetryPolicy(3);
$client         = new AsyncWebhookClient($httpClient, $retryPolicy);
$allowedIps     = ['127.0.0.1', '::1']; // разрешенные IP-адреса
$authentication = new IpAuthentication($allowedIps);
$logger         = new SimpleWebhookLogger();
$manager        = new WebhookManager($client, $authentication, $logger);
$handler        = new JwtWebhookHandler($secretKey);

// Text payload
$textPayload = new TextWebhookPayload('Hello, world!');
$textHeaders = new WebhookHeaders([
    'Content-Type' => 'text/plain',
]);
$textWebhook = new Webhook('https://example.com', $textHeaders, $textPayload);
$textEvent   = new WebhookEvent('test_event', $textWebhook);
$manager->registerHandler('test_event', $handler);
$manager->triggerEvent($textEvent);
echo "Text webhook delivered successfully with status code: ".$textEvent->getWebhook()->getResponseCode().PHP_EOL;

// Form URL encoded payload
$formData    = [
    'username' => 'johndoe',
    'password' => 'secret',
];
$formPayload = new FormUrlEncodedWebhookPayload($formData);
$formHeaders = new WebhookHeaders([
    'Content-Type' => 'application/x-www-form-urlencoded',
]);
$formWebhook = new Webhook('https://example.com', $formHeaders, $formPayload);
$formEvent   = new WebhookEvent('test_event', $formWebhook);
$manager->registerHandler('test_event', $handler);
$manager->triggerEvent($formEvent);
echo "Form URL encoded webhook delivered successfully with status code: ".$formEvent->getWebhook()->getResponseCode().PHP_EOL;
