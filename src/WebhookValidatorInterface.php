<?php

declare(strict_types=1);

namespace WebhookManager;

interface WebhookValidatorInterface
{
    public function validate(Webhook $webhook) : bool;
}