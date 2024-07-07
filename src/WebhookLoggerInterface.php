<?php

declare(strict_types=1);

namespace WebhookManager;

/**
 * Interface for Webhook Logger
 *
 * This interface defines the method that must be implemented by a class that wants to handle logging for webhooks.
 */
interface WebhookLoggerInterface
{
    /**
     * Logs a message.
     *
     * @param string $message The message to log.
     *
     * @return void
     */
    public function log(string $message) : void;
}
