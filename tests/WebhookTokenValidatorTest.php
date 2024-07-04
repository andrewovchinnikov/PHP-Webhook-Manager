<?php

use PHPUnit\Framework\TestCase;
use WebhookManager\Webhook;
use WebhookManager\WebhookTokenValidator;

class WebhookTokenValidatorTest extends TestCase
{
    public function testValidate(): void
    {
        $validator = new WebhookTokenValidator('secret');
        $webhook = new Webhook('https://example.com', ['X-Token' => 'abc123'], '{}');

        $this->assertFalse($validator->validate($webhook));

        $webhook = new Webhook('https://example.com', ['X-Token' => 'secret'], '{}');
        $this->assertTrue($validator->validate($webhook));
    }
}
