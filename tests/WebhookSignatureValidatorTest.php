<?php

use PHPUnit\Framework\TestCase;
use WebhookManager\Validators\WebhookSignatureValidator;
use WebhookManager\Webhook\Webhook;

class WebhookSignatureValidatorTest extends TestCase
{
    public function testValidate(): void
    {
        $validator = new WebhookSignatureValidator('secret');
        $webhook = new Webhook('https://example.com');

        $this->assertFalse($validator->validate($webhook));

        $webhook = new Webhook('https://example.com');
        $this->assertTrue($validator->validate($webhook));
    }
}
