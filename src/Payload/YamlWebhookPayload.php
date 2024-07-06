<?php

namespace WebhookManager\Payload;

use Symfony\Component\Yaml\Yaml;
use WebhookManager\WebhookPayloadInterface;

/**
 * Class YamlWebhookPayload
 *
 * This class represents a YAML payload for a webhook.
 */
class YamlWebhookPayload implements WebhookPayloadInterface
{
    /**
     * @var array $data The YAML data for the payload.
     */
    private array $data;

    /**
     * YamlWebhookPayload constructor.
     *
     * @param array $data The YAML data for the payload.
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Returns the YAML data as an array.
     *
     * @return array The YAML data as an array.
     */
    public function getData() : array
    {
        return $this->data;
    }

    /**
     * Sets the YAML data from an array.
     *
     * @param array $data The YAML data as an array.
     */
    public function setData(array $data) : void
    {
        $this->data = $data;
    }

    /**
     * Returns the format of the payload.
     *
     * @return string The format of the payload.
     */
    public function getFormat() : string
    {
        return 'yaml';
    }

    /**
     * Returns the YAML data as a string.
     *
     * @return string The YAML data as a string.
     */
    public function __toString() : string
    {
        return Yaml::dump($this->data);
    }

    /**
     * Returns the YAML data as a string.
     *
     * @return string The YAML data as a string.
     */
    public function getPayload() : string
    {
        return $this->__toString();
    }
}
