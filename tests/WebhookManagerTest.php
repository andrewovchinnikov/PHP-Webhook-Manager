<?php

use PHPUnit\Framework\TestCase;
use WebhookManager\Webhook;
use WebhookManager\WebhookEvent;
use WebhookManager\WebhookHandlerInterface;
use WebhookManager\WebhookManager;

class WebhookManagerTest extends TestCase
{
    public function testRegisterHandler(): void
    {
        $manager = new WebhookManager();
        $handler = $this->createMock(WebhookHandlerInterface::class);
        $manager->registerHandler('test_event', $handler);

        $this->assertCount(1, $manager->getHandlers('test_event'));
    }

    public function testTriggerEvent(): void
    {
        $manager = new WebhookManager();
        $handler = $this->createMock(WebhookHandlerInterface::class);
        $handler->expects($this->once())->method('handle');
        $manager->registerHandler('test_event', $handler);

        $webhook = new Webhook('https://example.com', [], '{}');
        $event = new WebhookEvent('test_event', $webhook);
        $manager->triggerEvent($event);
    }
}
