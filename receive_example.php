<?php

declare(strict_types=1);

require_once __DIR__.'/vendor/autoload.php';

use WebhookManager\ExampleWebhookHandler;
use WebhookManager\Webhook;
use WebhookManager\WebhookEvent;
use WebhookManager\WebhookManager;
use WebhookManager\WebhookClient;

$client  = new WebhookClient();
$manager = new WebhookManager($client);
$handler = new ExampleWebhookHandler();

$webhook = new Webhook('https://example.com', ['foo' => 'bar']);
$event   = new WebhookEvent('test_event', $webhook);

$manager->registerHandler('test_event', $handler);

$manager->triggerEvent($event);
