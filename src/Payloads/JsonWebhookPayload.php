<?php

declare(strict_types=1);

namespace WebhookManager\Payloads;

/**
 * Class JsonWebhookPayload
 *
 * This class represents a JSON payload for a webhook.
 * It implements the WebhookPayloadInterface interface.
 */
class JsonWebhookPayload implements WebhookPayloadInterface
{
    /**
     * @var array $data The data to be sent as the payload.
     */
    private array $data;

    /**
     * JsonWebhookPayload constructor.
     *
     * @param array $data The data to be sent as the payload.
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Gets the data to be sent as the payload.
     *
     * @return array The data to be sent as the payload.
     */
    public function getData() : array
    {
        return $this->data;
    }

    /**
     * Sets the data to be sent as the payload.
     *
     * @param array $data The data to be sent as the payload.
     */
    public function setData(array $data) : void
    {
        $this->data = $data;
    }

    /**
     * Gets the format of the payload.
     *
     * @return string The format of the payload.
     */
    public function getFormat() : string
    {
        return 'json';
    }

    /**
     * Converts the payload data to a string.
     *
     * @return string The payload data as a JSON string.
     */
    public function __toString() : string
    {
        return json_encode($this->data);
    }

    /**
     * Returns the payload data as a string.
     *
     * @return string The payload data as a JSON string.
     */
    public function getPayload() : string
    {
        return json_encode($this->data);
    }
}
