<?php

declare(strict_types=1);

namespace WebhookManager\Payloads;

use InvalidArgumentException;

/**
 * Class TextWebhookPayload
 *
 * This class represents a text payload for a webhook.
 *
 * @package WebhookManager
 */
class TextWebhookPayload implements WebhookPayloadInterface
{
    /**
     * @var string $data The text data of the payload.
     */
    private string $data;

    /**
     * TextWebhookPayload constructor.
     *
     * @param string $data The text data of the payload.
     */
    public function __construct(string $data)
    {
        $this->data = $data;
    }

    /**
     * Returns the string representation of the payload.
     *
     * @return string The string representation of the payload.
     */
    public function __toString() : string
    {
        return $this->data;
    }

    /**
     * Returns the data of the payload as an array.
     *
     * @return array The data of the payload as an array.
     */
    public function getData() : array
    {
        return ['data' => $this->data];
    }

    /**
     * Sets the data of the payload.
     *
     * @param array $data The data of the payload.
     *
     * @throws InvalidArgumentException If the data is not a string.
     */
    public function setData(array $data) : void
    {
        if (!isset($data['data']) || !is_string($data['data'])) {
            throw new InvalidArgumentException('Data must be a string');
        }

        $this->data = $data['data'];
    }

    /**
     * Returns the format of the payload.
     *
     * @return string The format of the payload.
     */
    public function getFormat() : string
    {
        return 'text/plain';
    }

    /**
     * Returns the data of the payload as a string.
     *
     * @return string The data of the payload as a string.
     */
    public function getPayload() : string
    {
        return $this->__toString();
    }
}
