<?php

declare(strict_types=1);

namespace WebhookManager;

/**
 * Class Webhook
 *
 * This class represents a webhook that can be sent to a specified URL with headers and payload.
 */
class Webhook
{
    /**
     * The URL to send the webhook to.
     *
     * @var string
     */
    private string $url;

    /**
     * The number of attempts made to send the webhook.
     *
     * @var int
     */
    private int $attempts = 0;

    /**
     * The HTTP response code received from the webhook server.
     *
     * @var int
     */
    private int $responseCode;

    /**
     * The response body received from the webhook server.
     *
     * @var string
     */
    private string $responseBody;

    /**
     * The headers to send with the webhook.
     *
     * @var WebhookHeaders
     */
    private WebhookHeaders $headers;

    /**
     * The payload to send with the webhook.
     *
     * @var WebhookPayloadInterface
     */
    private WebhookPayloadInterface $payload;

    /**
     * The client IP address that the webhook was sent from.
     *
     * @var string
     */
    private string $clientIp;

    /**
     * Constructs a new Webhook object.
     *
     * @param string                       $url      The URL to send the webhook to.
     * @param WebhookHeaders|null          $headers  The headers to send with the webhook.
     * @param WebhookPayloadInterface|null $payload  The payload to send with the webhook.
     * @param string                       $clientIp The client IP address that the webhook was sent from.
     */
    public function __construct(string $url, WebhookHeaders $headers = null, WebhookPayloadInterface $payload = null, string $clientIp = '')
    {
        $this->url          = $url;
        $this->headers      = $headers ?? new WebhookHeaders();
        $this->payload      = $payload ?? new JsonWebhookPayload();
        $this->responseCode = 0;
        $this->clientIp     = $clientIp;
    }

    /**
     * Gets the client IP address that the webhook was sent from.
     *
     * @return string The client IP address.
     */
    public function getClientIp() : string
    {
        return $this->clientIp;
    }

    /**
     * Sets the client IP address that the webhook was sent from.
     *
     * @param string $clientIp The client IP address.
     */
    public function setClientIp(string $clientIp) : void
    {
        $this->clientIp = $clientIp;
    }

    /**
     * Gets the URL to send the webhook to.
     *
     * @return string The URL.
     */
    public function getUrl() : string
    {
        return $this->url;
    }

    /**
     * Gets the headers to send with the webhook.
     *
     * @return WebhookHeaders The headers.
     */
    public function getHeaders() : WebhookHeaders
    {
        return $this->headers;
    }

    /**
     * Gets the payload to send with the webhook.
     *
     * @return WebhookPayloadInterface The payload.
     */
    public function getPayload(): string
    {
        return $this->payload->getPayload();
    }

    /**
     * Gets the number of attempts made to send the webhook.
     *
     * @return int The number of attempts.
     */
    public function getAttempts() : int
    {
        return $this->attempts;
    }

    /**
     * Sets the number of attempts made to send the webhook.
     *
     * @param int $attempts The number of attempts.
     */
    public function setAttempts(int $attempts) : void
    {
        $this->attempts = $attempts;
    }

    /**
     * Gets the HTTP response code received from the webhook server.
     *
     * @return int The response code.
     */
    public function getResponseCode() : int
    {
        return $this->responseCode;
    }

    /**
     * Sets the HTTP response code received from the webhook server.
     *
     * @param int $responseCode The response code.
     */
    public function setResponseCode(int $responseCode) : void
    {
        $this->responseCode = $responseCode;
    }

    /**
     * Gets the response body received from the webhook server.
     *
     * @return string The response body.
     */
    public function getResponseBody() : string
    {
        return $this->responseBody;
    }

    /**
     * Sets the response body received from the webhook server.
     *
     * @param string $responseBody The response body.
     */
    public function setResponseBody(string $responseBody) : void
    {
        $this->responseBody = $responseBody;
    }

    /**
     * Sets the HTTP response code and body received from the webhook server.
     *
     * @param int    $responseCode The response code.
     * @param string $responseBody The response body.
     */
    public function setResponse(int $responseCode, string $responseBody) : void
    {
        $this->responseCode = $responseCode;
        $this->responseBody = $responseBody;
    }
}
