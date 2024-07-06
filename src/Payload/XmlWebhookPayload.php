<?php

declare(strict_types=1);

namespace WebhookManager\Payload;

use SimpleXMLElement;
use WebhookManager\WebhookPayloadInterface;

/**
 * Class XmlWebhookPayload
 *
 * This class represents an XML payload for a webhook.
 */
class XmlWebhookPayload implements WebhookPayloadInterface
{
    /**
     * @var SimpleXMLElement $data The XML data for the payload.
     */
    private SimpleXMLElement $data;

    /**
     * XmlWebhookPayload constructor.
     *
     * @param SimpleXMLElement|null $data The XML data for the payload.
     */
    public function __construct(SimpleXMLElement $data = null)
    {
        $this->data = $data ?? new SimpleXMLElement('<?xml version="1.0"?><data></data>');
    }

    /**
     * Returns the XML data as an array.
     *
     * @return array The XML data as an array.
     */
    public function getData() : array
    {
        return json_decode(json_encode($this->data), true);
    }

    /**
     * Sets the XML data from an array.
     *
     * @param array $data The XML data as an array.
     */
    public function setData(array $data) : void
    {
        $this->data = json_decode(json_encode($data), false);
    }

    /**
     * Returns the format of the payload.
     *
     * @return string The format of the payload.
     */
    public function getFormat() : string
    {
        return 'xml';
    }

    /**
     * Returns the XML data as a string.
     *
     * @return string The XML data as a string.
     */
    public function __toString() : string
    {
        return $this->data->asXML();
    }

    /**
     * Returns the XML data as a string.
     *
     * @return string The XML data as a string.
     */
    public function getPayload() : string
    {
        return $this->__toString();
    }
}
