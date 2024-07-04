<?php

namespace WebhookManager;

class WebhookManager
{
    private array $handlers = [];

    public function registerHandler(string $eventName, WebhookHandlerInterface $handler) : void
    {
        $this->handlers[$eventName][] = $handler;
    }

    public function triggerEvent(WebhookEvent $event) : void
    {
        if (!isset($this->handlers[$event->getName()])) {
            return;
        }

        foreach ($this->handlers[$event->getName()] as $handler) {
            $handler->handle($event);
        }
    }
}