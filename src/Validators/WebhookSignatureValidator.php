<?php

declare(strict_types=1);

namespace WebhookManager\Validators;

use WebhookManager\Webhook\Webhook;

/**
 * Class WebhookSignatureValidator
 *
 * This class validates the signature of incoming webhooks using a secret key.
 * It implements the WebhookValidatorInterface interface.
 */
class WebhookSignatureValidator implements WebhookValidatorInterface
{
    /**
     * @var string $secret The secret key used to generate the signature.
     */
    private string $secret;

    /**
     * WebhookSignatureValidator constructor.
     *
     * @param string $secret The secret key used to generate the signature.
     */
    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    /**
     * Validates the signature of the incoming webhook.
     *
     * @param Webhook $webhook The incoming webhook.
     *
     * @return bool True if the signature is valid, false otherwise.
     */
    public function validate(Webhook $webhook) : bool
    {
        // Get the signature from the X-Signature header.
        $signature = $webhook->getHeaders()['X-Signature'] ?? '';

        // Generate the expected signature using the secret key and the payload.
        $computedSignature = hash_hmac('sha256', $webhook->getPayload(), $this->secret);

        // Compare the signatures using the hash_equals function to prevent timing attacks.
        return hash_equals($signature, $computedSignature);
    }
}
