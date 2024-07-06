<?php

declare(strict_types=1);

namespace WebhookManager;

/**
 * Class WebhookEvent
 *
 * This class represents a webhook event that occurred.
 * It contains the name of the event and the associated webhook object.
 */
class WebhookEvent
{
    /**
     * @var string The name of the event.
     */
    private string $name;

    /**
     * @var Webhook The associated webhook object.
     */
    private Webhook $webhook;

    /**
     * WebhookEvent constructor.
     *
     * @param string  $name    The name of the event.
     * @param Webhook $webhook The associated webhook object.
     */
    public function __construct(string $name, Webhook $webhook)
    {
        $this->name    = $name;
        $this->webhook = $webhook;
    }

    /**
     * Gets the name of the event.
     *
     * @return string The name of the event.
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Gets the associated webhook object.
     *
     * @return Webhook The associated webhook object.
     */
    public function getWebhook() : Webhook
    {
        return $this->webhook;
    }
}
