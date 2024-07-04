<?php

namespace WebhookManager;

class WebhookHeaders implements WebhookHeadersInterface
{
    public function offsetExists($offset) : bool
    {
        return array_key_exists($offset, $this->headers);
    }

    public function offsetGet($offset) : ?string
    {
        return $this->headers[$offset] ?? null;
    }

    public function offsetSet($offset, $value) : void
    {
        $this->headers[$offset] = $value;
    }

    public function offsetUnset($offset) : void
    {
        unset($this->headers[$offset]);
    }

    private array $headers = [];

    public function __construct(array $headers = [])
    {
        $this->headers = $headers;
    }

    public function getHeaders() : array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers) : void
    {
        $this->headers = $headers;
    }

    public function addHeader(string $name, string $value) : void
    {
        $this->headers[$name] = $value;
    }

    public function removeHeader(string $name) : void
    {
        unset($this->headers[$name]);
    }

    public function hasHeader(string $name) : bool
    {
        return array_key_exists($name, $this->headers);
    }

    public function getHeader(string $name) : ?string
    {
        return $this->headers[$name] ?? null;
    }
}
