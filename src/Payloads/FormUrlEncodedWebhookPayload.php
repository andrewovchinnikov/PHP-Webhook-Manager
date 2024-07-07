<?php

declare(strict_types=1);

namespace WebhookManager\Payloads;

use InvalidArgumentException;

/**
 * Class for creating webhook payload in "application/x-www-form-urlencoded" format.
 */
class FormUrlEncodedWebhookPayload implements WebhookPayloadInterface
{
    /**
     * Data for webhook payload.
     *
     * @var array
     */
    private array $data;

    /**
     * Class constructor.
     *
     * @param array $data Data for webhook payload.
     *
     * @throws InvalidArgumentException If data is empty.
     */
    public function __construct(array $data)
    {
        if (empty($data)) {
            throw new InvalidArgumentException('Data cannot be empty');
        }

        $this->data = $data;
    }

    /**
     * Converts webhook payload to string.
     *
     * @return string Webhook payload as string.
     */
    public function __toString() : string
    {
        return http_build_query($this->data);
    }

    /**
     * Returns data for webhook payload.
     *
     * @return array Data for webhook payload.
     */
    public function getData() : array
    {
        return $this->data;
    }

    /**
     * Sets data for webhook payload.
     *
     * @param array $data Data for webhook payload.
     *
     * @throws InvalidArgumentException If data is empty.
     */
    public function setData(array $data) : void
    {
        if (empty($data)) {
            throw new InvalidArgumentException('Data cannot be empty');
        }

        $this->data = $data;
    }

    /**
     * Returns format of webhook payload.
     *
     * @return string Format of webhook payload.
     */
    public function getFormat() : string
    {
        return 'application/x-www-form-urlencoded';
    }

    /**
     * Returns webhook payload as string.
     *
     * @return string Webhook payload as string.
     */
    public function getPayload() : string
    {
        return $this->__toString();
    }
}
