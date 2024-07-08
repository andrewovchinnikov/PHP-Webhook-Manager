<?php

// включаем строгий режим типизации
declare(strict_types=1);

// подключаем автозагрузчик композера
require_once __DIR__.'/../.././vendor/autoload.php';


// подключаем необходимые классы
use GuzzleHttp\Client;
use WebhookManager\Authentication\JwtAuthentication;
use WebhookManager\Events\WebhookEvent;
use WebhookManager\Handlers\JwtWebhookHandler;
use WebhookManager\Headers\WebhookHeaders;
use WebhookManager\Clients\HttpWebhookClient;
use WebhookManager\Loggers\SimpleWebhookLogger;
use WebhookManager\Payloads\TextWebhookPayload;
use WebhookManager\Policy\SimpleRetryPolicy;
use WebhookManager\Webhook\Webhook;
use WebhookManager\Webhook\WebhookManager;

// секретный ключ для JWT-авторизации
$secretKey = 'mysecretkey';

// данные для отправки в веб-хук
$data = ['foo' => 'bar', 'baz' => ['qux' => 'quux']];

// создаем HTTP-клиент для отправки запросов
$httpClient = new Client();

// создаем политику повтора отправки веб-хука в случае ошибки
$retryPolicy = new SimpleRetryPolicy(3);

// создаем клиент для отправки веб-хуков
$client = new HttpWebhookClient($httpClient, $retryPolicy);

// создаем объект для JWT-авторизации
$authentication = new JwtAuthentication($secretKey);

// создаем логгер для веб-хуков
$logger = new SimpleWebhookLogger();

// создаем менеджер для веб-хуков
$manager = new WebhookManager($client, $authentication, $logger);

// создаем обработчик для входящих веб-хуков
$handler = new JwtWebhookHandler($secretKey);

// создаем текстовую полезную нагрузку для веб-хука
$textPayload = new TextWebhookPayload('Hello, world!');

// создаем заголовки для веб-хука
$textHeaders = new WebhookHeaders([
    'Content-Type' => 'text/plain',
]);

// создаем веб-хук
$webhook = new Webhook('https://example.com', $textHeaders, $textPayload);

// создаем событие для веб-хука
$event = new WebhookEvent('test_event', $webhook);

// регистрируем обработчик для события
$manager->registerHandler('test_event', $handler);

// запускаем событие
try {
    $manager->triggerEvent($event);
} catch (Exception $e) {
    // выводим сообщение об ошибке
    echo $e->getMessage();
}
