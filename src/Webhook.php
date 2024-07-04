<?php

namespace WebhookManager;

class Webhook
{
    private string $url;
    private array  $headers;
    private string $payload;
    private int    $attempts = 0;
    private int    $responseCode;
    private string $responseBody;

    public function __construct(string $url, array $headers = [], WebhookPayloadInterface $payload = null)
    {
        $this->url          = $url;
        $this->headers      = $headers;
        $this->payload      = $payload ?? new JsonWebhookPayload();
        $this->responseCode = 0;
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

    public function getAttempts() : int
    {
        return $this->attempts;
    }

    public function setAttempts(int $attempts) : void
    {
        $this->attempts = $attempts;
    }

    public function getResponseCode() : int
    {
        return $this->responseCode;
    }

    public function setResponseCode(int $responseCode) : void
    {
        $this->responseCode = $responseCode;
    }

    public function getResponseBody() : string
    {
        return $this->responseBody;
    }

    public function setResponseBody(string $responseBody) : void
    {
        $this->responseBody = $responseBody;
    }

    public function setResponse(int $responseCode, string $responseBody) : void
    {
        $this->responseCode = $responseCode;
        $this->responseBody = $responseBody;
    }
}
