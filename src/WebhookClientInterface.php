<?php

declare(strict_types=1);

namespace WebhookManager;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface for Webhook Client
 *
 * This interface defines the method that must be implemented by a class that sends webhooks.
 */
interface WebhookClientInterface
{
    /**
     * Sends a webhook and returns the response.
     *
     * @param Webhook $webhook The webhook object containing the data to be sent.
     *
     * @return ResponseInterface The response object containing the server's response.
     */
    public function send(Webhook $webhook) : ResponseInterface;
}
