<?php

declare(strict_types=1);

namespace WebhookManager;

interface WebhookPayloadInterface
{
    public function getData(): array;

    public function setData(array $data): void;

    public function getFormat(): string;
}
