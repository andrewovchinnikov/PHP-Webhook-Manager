<?php

namespace WebhookManager\Authentication;

use InvalidArgumentException;
use WebhookManager\Webhook\Webhook;

/**
 * Class IpAuthentication
 *
 * This class provides IP authentication for webhooks.
 * It checks if the client IP address is in the list of allowed IP addresses.
 */
class IpAuthenticationInterface implements WebhookAuthenticationInterface
{
    /**
     * @var array $allowedIps The list of allowed IP addresses.
     */
    private array $allowedIps;

    /**
     * IpAuthentication constructor.
     *
     * @param array $allowedIps The list of allowed IP addresses.
     *
     * @throws InvalidArgumentException If the list of allowed IP addresses is empty.
     */
    public function __construct(array $allowedIps)
    {
        if (empty($allowedIps)) {
            throw new InvalidArgumentException('Allowed IPs cannot be empty');
        }

        $this->allowedIps = $allowedIps;
    }

    /**
     * Authenticates the webhook.
     *
     * @param Webhook $webhook The webhook to authenticate.
     *
     * @return bool True if the client IP address is in the list of allowed IP addresses, false otherwise.
     */
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
