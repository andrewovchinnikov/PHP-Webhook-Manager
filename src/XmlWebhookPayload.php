<?php

declare(strict_types=1);

namespace WebhookManager;

class XmlWebhookPayload implements WebhookPayloadInterface
{
    private \SimpleXMLElement $data;

    public function __construct(\SimpleXMLElement $data = null)
    {
        $this->data = $data ?? new \SimpleXMLElement('<?xml version="1.0"?><data></data>');
    }

    public function getData(): array
    {
        return json_decode(json_encode($this->data), true);
    }

    public function setData(array $data): void
    {
        $this->data = json_decode(json_encode($data), false);
    }

    public function getFormat(): string
    {
        return 'xml';
    }

    public function __toString(): string
    {
        return $this->data->asXML();
    }
}
