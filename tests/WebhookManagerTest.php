<?php

declare(strict_types=1);

use WebhookManager\Webhook;
use PHPUnit\Framework\TestCase;
use WebhookManager\WebhookManager;
use WebhookManager\WebhookEvent;
use WebhookManager\WebhookHandlerInterface;
use WebhookManager\WebhookClientInterface;
use WebhookManager\WebhookAuthenticationInterface;
use WebhookManager\WebhookLoggerInterface;

// Mock interfaces
class MockWebhookHandler implements WebhookHandlerInterface
{
    public function handle(WebhookEvent $event) : void
    {
    }
}

class MockWebhookClient implements WebhookClientInterface
{
    public function send($webhook) : \Psr\Http\Message\ResponseInterface
    {
        return new \GuzzleHttp\Psr7\Response(200);
    }
}

class MockWebhookAuthentication implements WebhookAuthenticationInterface
{
    public function authenticate(Webhook $webhook) : bool
    {
        return true;
    }
}

class MockWebhookLogger implements WebhookLoggerInterface
{
    public function log($message) : void
    {
    }
}

class WebhookManagerTest extends TestCase
{
    private WebhookManager $webhookManager;

    protected function setUp() : void
    {
        // Initialize WebhookManager with mock objects
        $this->webhookManager = new WebhookManager(
            new MockWebhookClient(),
            new MockWebhookAuthentication(),
            new MockWebhookLogger()
        );
    }

    public function testRegisterHandler() : void
    {
        // Create a mock handler
        $handler = new MockWebhookHandler();

        // Register the handler
        $this->webhookManager->registerHandler('testEvent', $handler);

        // Check if the handler is registered
        $this->assertTrue($this->webhookManager->hasHandler('testEvent', $handler));
    }

    /**
     * @throws Exception
     */
    public function testTriggerEvent() : void
    {
        // Create a mock handler and event
        $handler = $this->createMock(WebhookHandlerInterface::class);
        $webhook = new Webhook('http://example.com/webhook');

        $event = new WebhookEvent('testEvent', $webhook);

        // Configure the mock to expect a call to the handle method
        $handler->expects($this->once())
                ->method('handle')
                ->with($this->equalTo($event));

        // Register the handler
        $this->webhookManager->registerHandler('testEvent', $handler);

        // Trigger the event
        $this->webhookManager->triggerEvent($event);
    }
}
