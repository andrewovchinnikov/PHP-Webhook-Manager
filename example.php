<?php

require_once __DIR__.'/vendor/autoload.php';

use WebhookManager\ExampleWebhookHandler;
use WebhookManager\Webhook;
use WebhookManager\WebhookEvent;
use WebhookManager\WebhookManager;

$manager = new WebhookManager();
$handler = new ExampleWebhookHandler();

$webhook = new Webhook('https://example.com', ['foo' => 'bar']);
$event   = new WebhookEvent('test_event', $webhook);

$manager->registerHandler('test_event', $handler);

$manager->triggerEvent($event);
