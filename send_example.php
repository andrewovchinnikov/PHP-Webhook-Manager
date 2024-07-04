<?php

declare(strict_types=1);

require_once __DIR__.'/vendor/autoload.php';

use WebhookManager\Webhook;
use WebhookManager\WebhookClient;

$webhook = new Webhook('https://webhook.site/6acc75e2-0b38-4c87-b41a-3e8ab63cdd0d', ['Content-Type' => 'application/json'], '{"foo": "bar"}');

$client = new WebhookClient();
$client->send($webhook);
