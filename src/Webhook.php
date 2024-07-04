<?php

namespace WebhookManager;

class Webhook
{
    private string $url;
    private array  $headers;
    private string $payload;

    public function __construct(string $url, array $headers = [], string $payload = '')
    {
        $this->url     = $url;
        $this->headers = $headers;
        $this->payload = $payload;
    }

    public function getUrl() : string
    {
        return $this->url;
    }

    public function getHeaders() : array
    {
        return $this->headers;
    }

    public function getPayload() : string
    {
        return $this->payload;
    }
}