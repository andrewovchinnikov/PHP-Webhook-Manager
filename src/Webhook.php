<?php

namespace WebhookManager;

class Webhook
{
    private string                  $url;
    private int                     $attempts = 0;
    private int                     $responseCode;
    private string                  $responseBody;
    private WebhookHeaders          $headers;
    private WebhookPayloadInterface $payload;
    private string                 $clientIp;

    public function __construct(string $url, WebhookHeaders $headers = null, WebhookPayloadInterface $payload = null, string $clientIp = '')
    {
        $this->url          = $url;
        $this->headers      = $headers ?? new WebhookHeaders();
        $this->payload      = $payload ?? new JsonWebhookPayload();
        $this->responseCode = 0;
        $this->clientIp     = $clientIp;
    }

    public function getClientIp() : string
    {
        return $this->clientIp;
    }

    public function setClientIp(string $clientIp) : void
    {
        $this->clientIp = $clientIp;
    }

    public function getUrl() : string
    {
        return $this->url;
    }

    public function getHeaders() : WebhookHeaders
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
