<?php

use PHPUnit\Framework\TestCase;
use WebhookManager\Webhook;
use WebhookManager\WebhookSignatureValidator;

class WebhookSignatureValidatorTest extends TestCase
{
    public function testValidate(): void
    {
        $validator = new WebhookSignatureValidator('secret');
        $webhook = new Webhook('https://example.com', ['X-Signature' => 'sha256=abc123'], '{}');

        $this->assertFalse($validator->validate($webhook));

        $webhook = new Webhook('https://example.com', ['X-Signature' => 'sha256=5f4dcc3b5aa765d61d8327deb882cf99'], '{}');
        $this->assertTrue($validator->validate($webhook));
    }
}
