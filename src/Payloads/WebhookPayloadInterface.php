<?php

declare(strict_types=1);

namespace WebhookManager\Payloads;

/**
 * Interface for webhook payload objects.
 *
 * This interface defines the methods that a payload object must implement.
 */
interface WebhookPayloadInterface
{
    /**
     * Get the data of the payload as an array.
     *
     * @return array The data of the payload.
     */
    public function getData() : array;

    /**
     * Set the data of the payload.
     *
     * @param array $data The data of the payload.
     */
    public function setData(array $data) : void;

    /**
     * Get the format of the payload.
     *
     * @return string The format of the payload.
     */
    public function getFormat() : string;

    /**
     * Get the string representation of the payload.
     *
     * @return string The string representation of the payload.
     */
    public function getPayload(): string;
}
