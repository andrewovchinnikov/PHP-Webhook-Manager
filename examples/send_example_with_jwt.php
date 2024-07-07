<?php

declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

use exception\WebhookDeliveryException;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use WebhookManager\Authentication\JwtAuthentication;
use WebhookManager\Events\WebhookEvent;
use WebhookManager\Handlers\JwtWebhookHandler;
use WebhookManager\Clients\HttpWebhookClient;
use WebhookManager\Loggers\SimpleWebhookLogger;
use WebhookManager\Policy\SimpleRetryPolicy;
use WebhookManager\Webhook\Webhook;
use WebhookManager\Webhook\WebhookManager;

$secretKey      = 'mysecretkey';
$data           = 'Тестовые данные';
$httpClient     = new Client();
$retryPolicy    = new SimpleRetryPolicy(3);
$client         = new HttpWebhookClient($httpClient, $retryPolicy);
$authentication = new JwtAuthentication($secretKey);
$logger         = new SimpleWebhookLogger();
$manager        = new WebhookManager($client, $authentication, $logger);
$handler        = new JwtWebhookHandler($secretKey);

$token = JWT::encode(['data' => $data], $secretKey, 'HS256');

$webhook = new Webhook('https://webhook.site/6acc75e2-0b38-4c87-b41a-3e8ab63cdd0d', [
    'Authorization' => "$token",
    'Content-Type'  => 'application/json',
], $data);
$event   = new WebhookEvent('test_event', $webhook);

$manager->registerHandler('test_event', $handler);

try {
    $manager->triggerEvent($event);
    $statusCode = $event->getWebhook()->getResponseCode();
    echo "Webhook delivered successfully with status code: $statusCode";
} catch (WebhookDeliveryException $e) {
    echo "Error delivering webhook: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
