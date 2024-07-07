<?php

declare(strict_types=1);

namespace WebhookManager\Handlers;

use Exception;
use Firebase\JWT\JWT;
use WebhookManager\Events\WebhookEvent;

/**
 * Class JwtWebhookHandler
 *
 * This class handles incoming webhook requests and verifies their JWT authentication.
 * It also processes the payload data and sets the response code.
 */
class JwtWebhookHandler implements WebhookHandlerInterface
{
    /**
     * @var string $secretKey The secret key used to encode and decode the JWT token.
     */
    private string $secretKey;

    /**
     * JwtWebhookHandler constructor.
     *
     * @param string $secretKey The secret key used to encode and decode the JWT token.
     */
    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * Handles the incoming webhook request.
     *
     * @param WebhookEvent $event The event object containing the webhook request data.
     *
     * @return void
     */
    public function handle(WebhookEvent $event) : void
    {
        $webhook = $event->getWebhook();

        // Get the authorization header containing the JWT token.
        $token = $webhook->getHeaders()['Authorization'] ?? '';

        try {
            // Decode the JWT token using the secret key and the HS256 algorithm.
            $decoded = JWT::decode($token, $this->secretKey, ['HS256']);

            // Decode the payload data from JSON format.
            $data = json_decode($webhook->getPayload(), true);

            // Process the payload data.
            // Here you can handle the data as needed.
            echo "Received data: ";
            print_r($data);

            // Set the response code to 200 OK.
            $webhook->setResponseCode(200);
        } catch (Exception $e) {
            // If there was an error decoding the JWT token, set the response code to 401 Unauthorized.
            $webhook->setResponseCode(401);
        }
    }
}
