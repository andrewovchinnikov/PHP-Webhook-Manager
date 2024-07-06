<?php

declare(strict_types=1);

namespace WebhookManager;

/**
 * Interface WebhookHandlerInterface
 *
 * This interface defines the method that must be implemented by a class that handles webhook events.
 *
 * @package WebhookManager
 */
interface WebhookHandlerInterface
{
    /**
     * Handles a webhook event.
     *
     * @param WebhookEvent $event The webhook event to handle.
     *
     * @return void
     */
    public function handle(WebhookEvent $event) : void;
}
