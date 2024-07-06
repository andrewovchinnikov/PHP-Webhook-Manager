<?php

declare(strict_types=1);

namespace WebhookManager;

use Exception;
use Firebase\JWT\JWT;

/**
 * Class JwtAuthentication
 *
 * This class provides JWT based authentication for webhooks.
 */
class JwtAuthentication implements WebhookAuthentication
{
    /**
     * @var string $secretKey The secret key used to sign the JWT token.
     */
    private string $secretKey;

    /**
     * JwtAuthentication constructor.
     *
     * @param string $secretKey The secret key used to sign the JWT token.
     */
    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * Authenticate the webhook using JWT.
     *
     * @param Webhook $webhook The webhook object to authenticate.
     *
     * @return bool True if the webhook is authenticated, false otherwise.
     */
    public function authenticate(Webhook $webhook) : bool
    {
        try {
            // Get the authorization header and extract the JWT token.
            $token = $webhook->getHeaders()['Authorization'] ?? '';

            // Decode the JWT token using the secret key and HS256 algorithm.
            $decoded = JWT::decode($token, $this->secretKey, ['HS256']);

            // If the token is valid, return true.
            return true;
        } catch (Exception $e) {
            // If there is an error while decoding the token, return false.
            return false;
        }
    }
}
