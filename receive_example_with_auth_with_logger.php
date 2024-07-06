<?php

declare(strict_types=1);

require_once __DIR__.'/vendor/autoload.php';

use GuzzleHttp\Client;
use Psr\Log\NullLogger;
use WebhookManager\Authentication\SecretKeyAuthentication;
use WebhookManager\ExampleWebhookHandler;
use WebhookManager\SimpleRetryPolicy;
use WebhookManager\SimpleWebhookLogger;
use WebhookManager\Webhook;
use WebhookManager\WebhookClient;
use WebhookManager\WebhookEvent;
use WebhookManager\WebhookManager;

// Создаем экземпляр HTTP-клиента
$httpClient = new Client();

// Создаем политику повторной отправки веб-хука
$retryPolicy = new SimpleRetryPolicy(3);

// Создаем экземпляр клиента для отправки веб-хуков
$client = new WebhookClient($httpClient, $retryPolicy);

// Создаем логгер
$logger = new SimpleWebhookLogger();

// Создаем экземпляр аутентификации веб-хука
$secretKey      = 'my-secret-key';
$authentication = new SecretKeyAuthentication($secretKey);

// Создаем экземпляр менеджера веб-хуков
$manager = new WebhookManager($client, $authentication, $logger);

// Создаем обработчик веб-хука
$handler = new ExampleWebhookHandler();

// Регистрируем обработчик для события "test_event"
$manager->registerHandler('test_event', $handler);

// Создаем веб-хук
$data    = '{"foo":"bar"}';
$webhook = new Webhook('https://example.com', [
    'X-Signature'  => hash_hmac('sha256', $data, $secretKey),
    'Content-Type' => 'application/json',
], $data);

// Создаем событие веб-хука
$event = new WebhookEvent('test_event', $webhook);

// Триггерим событие
try {
    $manager->triggerEvent($event);
} catch (Exception $e) {
    echo $e->getMessage();
}
