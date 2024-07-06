<?php

namespace WebhookManager;

use WebhookManager\WebhookAuthentication;

/**
 * Class SecretKeyAuthentication
 *
 * This class provides authentication for incoming webhooks using a secret key.
 * It checks the X-Signature header of the incoming request against a generated HMAC hash of the request payload.
 */
class SecretKeyAuthentication implements WebhookAuthentication
{
    /**
     * @var string $secretKey The secret key used to generate the HMAC hash.
     */
    private string $secretKey;

    /**
     * SecretKeyAuthentication constructor.
     *
     * @param string $secretKey The secret key used to generate the HMAC hash.
     */
    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * Authenticates the incoming webhook request.
     *
     * @param Webhook $webhook The incoming webhook request.
     *
     * @return bool True if the request is authenticated, false otherwise.
     */
    public function authenticate(Webhook $webhook) : bool
    {
        // Generate the HMAC hash using the secret key and the request payload.
        $signature = hash_hmac('sha256', $webhook->getPayload(), $this->secretKey);

        // Get the X-Signature header from the incoming request.
        $expectedSignature = $webhook->getHeaders()['X-Signature'] ?? '';

        // Compare the generated HMAC hash with the X-Signature header using the hash_equals function to prevent timing attacks.
        return hash_equals($signature, $expectedSignature);
    }
}
