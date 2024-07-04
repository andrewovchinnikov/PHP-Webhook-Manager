<?php

declare(strict_types=1);

namespace WebhookManager;

use Exception;
use Firebase\JWT\JWT;

class JwtWebhookHandler implements WebhookHandlerInterface
{
    private string $secretKey;

    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;
    }

    public function handle(WebhookEvent $event): void
    {
        $webhook = $event->getWebhook();
        $token = $webhook->getHeaders()['Authorization'] ?? '';

        try {
            $decoded = JWT::decode($token, $this->secretKey, ['HS256']);
            $data = json_decode($webhook->getPayload(), true);

            // Здесь вы можете обработать данные веб-хука
            echo "Received data: ";
            print_r($data);

            $webhook->setResponseCode(200);
        } catch (Exception $e) {
            $webhook->setResponseCode(401);
        }
    }


}
