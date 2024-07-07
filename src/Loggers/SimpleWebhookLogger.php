<?php

declare(strict_types=1);

namespace WebhookManager\Loggers;

/**
 * SimpleWebhookLogger class is an implementation of the WebhookLogger interface.
 * It logs messages using the error_log() function.
 */
class SimpleWebhookLogger implements WebhookLoggerInterface
{
    /**
     * Logs a message using the error_log() function.
     *
     * @param string $message The message to be logged.
     *
     * @return void
     */
    public function log(string $message) : void
    {
        error_log($message);
    }
}
