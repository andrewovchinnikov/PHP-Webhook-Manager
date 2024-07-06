<?php

declare(strict_types=1);

namespace WebhookManager;

use Psr\Http\Message\RequestInterface;

class WebhookBuilder
{
    private WebhookHeaders     $headers;
    private JsonWebhookPayload $payload;
    private string             $url;

    public function __construct()
    {
        $this->headers = new WebhookHeaders();
        $this->payload = new JsonWebhookPayload([]);
    }

    public function withUrl(string $url) : self
    {
        $this->url = $url;

        return $this;
    }

    public function withHeaders(array $headers) : self
    {
        foreach ($headers as $name => $value) {
            $this->headers->addHeader($name, $value);
        }

        return $this;
    }

    public function withPayload(array $payload) : self
    {
        $this->payload = new JsonWebhookPayload($payload);

        return $this;
    }

    public function build() : Webhook
    {
        return new Webhook($this->url, $this->headers, $this->payload);
    }

    public function createFromRequest(RequestInterface $request) : Webhook
    {
        // Get the URL from the request.
        $url = $request->getUri()->getPath();

        // Get the headers from the request.
        foreach ($request->getHeaders() as $name => $values) {
            $this->headers->addHeader($name, implode(', ', $values));
        }

        // Get the body from the request.
        $body = $request->getBody()->getContents();

        // Decode the body as JSON.
        $data = json_decode($body, true);

        // Check if the body is valid JSON.
        if (json_last_error() !== JSON_ERROR_NONE) {
            // If not, create an empty payload object.
            $this->payload = new JsonWebhookPayload([]);
        } else {
            // If yes, create a payload object from the data.
            $this->payload = new JsonWebhookPayload($data);
        }

        // Create a new Webhook object.
        return $this->build();
    }
}
