<?php

declare(strict_types=1);

namespace WebhookManager;

/**
 * Interface WebhookAuthentication
 *
 * This interface defines the method for authenticating a webhook.
 * Any class that implements this interface must define the authenticate() method.
 */
interface WebhookAuthentication
{
    /**
     * Authenticates a webhook.
     *
     * @param Webhook $webhook The webhook object to authenticate.
     *
     * @return bool True if the webhook is authenticated, false otherwise.
     */
    public function authenticate(Webhook $webhook) : bool;
}
