<?php

declare(strict_types=1);

namespace WebhookManager;

/**
 * Class WebhookHeaders
 *
 * This class implements the WebhookHeadersInterface and provides methods to manage headers for a webhook request.
 */
class WebhookHeaders implements WebhookHeadersInterface
{
    /**
     * Checks if a header exists.
     *
     * @param string $offset The header name.
     *
     * @return bool True if the header exists, false otherwise.
     */
    public function offsetExists($offset) : bool
    {
        return array_key_exists($offset, $this->headers);
    }

    /**
     * Gets the value of a header.
     *
     * @param string $offset The header name.
     *
     * @return string|null The header value, or null if the header does not exist.
     */
    public function offsetGet($offset) : ?string
    {
        return $this->headers[$offset] ?? null;
    }

    /**
     * Sets the value of a header.
     *
     * @param string $offset The header name.
     * @param string $value  The header value.
     */
    public function offsetSet($offset, $value) : void
    {
        $this->headers[$offset] = $value;
    }

    /**
     * Unsets a header.
     *
     * @param string $offset The header name.
     */
    public function offsetUnset($offset) : void
    {
        unset($this->headers[$offset]);
    }

    /**
     * The headers for the webhook request.
     *
     * @var array
     */
    private array $headers = [];

    /**
     * Constructs a new WebhookHeaders object.
     *
     * @param array $headers The headers for the webhook request.
     */
    public function __construct(array $headers = [])
    {
        $this->headers = $headers;
    }

    /**
     * Gets all headers.
     *
     * @return array The headers for the webhook request.
     */
    public function getHeaders() : array
    {
        return $this->headers;
    }

    /**
     * Sets all headers.
     *
     * @param array $headers The headers for the webhook request.
     */
    public function setHeaders(array $headers) : void
    {
        $this->headers = $headers;
    }

    /**
     * Adds a header to the webhook request.
     *
     * @param string $name  The header name.
     * @param string $value The header value.
     */
    public function addHeader(string $name, string $value) : void
    {
        $this->headers[$name] = $value;
    }

    /**
     * Removes a header from the webhook request.
     *
     * @param string $name The header name.
     */
    public function removeHeader(string $name) : void
    {
        unset($this->headers[$name]);
    }

    /**
     * Checks if a header exists.
     *
     * @param string $name The header name.
     *
     * @return bool True if the header exists, false otherwise.
     */
    public function hasHeader(string $name) : bool
    {
        return array_key_exists($name, $this->headers);
    }

    /**
     * Gets the value of a header.
     *
     * @param string $name The header name.
     *
     * @return string|null The header value, or null if the header does not exist.
     */
    public function getHeader(string $name) : ?string
    {
        return $this->headers[$name] ?? null;
    }
}
