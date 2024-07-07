<?php

declare(strict_types=1);

namespace WebhookManager\Validators;

use WebhookManager\Webhook\Webhook;

/**
 * Interface WebhookValidatorInterface
 *
 * This interface defines the method that must be implemented by any class that validates incoming webhooks.
 */
interface WebhookValidatorInterface
{
    /**
     * Validates the incoming webhook.
     *
     * @param Webhook $webhook The incoming webhook.
     *
     * @return bool True if the webhook is valid, false otherwise.
     */
    public function validate(Webhook $webhook) : bool;
}
