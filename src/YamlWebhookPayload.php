<?php

namespace WebhookManager;

use Symfony\Component\Yaml\Yaml;

class YamlWebhookPayload implements WebhookPayloadInterface
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
        return 'yaml';
    }

    public function __toString(): string
    {
        return Yaml::dump($this->data);
    }
}
