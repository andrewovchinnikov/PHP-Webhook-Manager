<?php

namespace WebhookManager;

use InvalidArgumentException;

class IpAuthentication implements WebhookAuthentication
{
    private array $allowedIps;

    public function __construct(array $allowedIps)
    {
        if (empty($allowedIps)) {
            throw new InvalidArgumentException('Allowed IPs cannot be empty');
        }

        $this->allowedIps = $allowedIps;
    }

    public function authenticate(Webhook $webhook) : bool
    {
        $clientIp = $webhook->getClientIp();

        if ($clientIp === '') {
            return false;
        }

        if (!in_array($clientIp, $this->allowedIps)) {
            return false;
        }

        return true;
    }
}