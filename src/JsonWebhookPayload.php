<?php

declare(strict_types=1);

namespace WebhookManager;

class JsonWebhookPayload implements WebhookPayloadInterface
{
    private array $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function getFormat(): string
    {
        return 'json';
    }

    public function __toString(): string
    {
        return json_encode($this->data);
    }
}
