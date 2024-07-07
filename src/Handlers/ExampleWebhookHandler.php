<?php

declare(strict_types=1);

namespace WebhookManager\Handlers;

use WebhookManager\Events\WebhookEvent;

/**
 * Example webhook event handler.
 */
class ExampleWebhookHandler implements WebhookHandlerInterface
{
    /**
     * Handles webhook event.
     *
     * @param WebhookEvent $event Webhook event.
     */
    public function handle(WebhookEvent $event) : void
    {
        // You can add your code for handling webhook event here
        echo sprintf('Received event "%s" with data: %s', $event->getName(), $event->getWebhook()->getPayload());
    }
}
