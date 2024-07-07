<?php

declare(strict_types=1);

namespace WebhookManager\Validators;

use WebhookManager\Webhook\Webhook;

/**
 * Class WebhookTokenValidator
 *
 * This class validates the token of incoming webhooks using a pre-shared token.
 */
class WebhookTokenValidator
{
    /**
     * @var string $token The pre-shared token used to validate the webhook.
     */
    private string $token;

    /**
     * WebhookTokenValidator constructor.
     *
     * @param string $token The pre-shared token used to validate the webhook.
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Validates the token of the incoming webhook.
     *
     * @param Webhook $webhook The incoming webhook.
     *
     * @return bool True if the token is valid, false otherwise.
     */
    public function validate(Webhook $webhook) : bool
    {
        // Get the token from the X-Token header of the webhook.
        $token = $webhook->getHeaders()['X-Token'] ?? '';

        // Compare the token with the pre-shared token using the hash_equals function to prevent timing attacks.
        return hash_equals($token, $this->token);
    }
}
