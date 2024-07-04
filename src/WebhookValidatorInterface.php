<?php

namespace WebhookManager;

interface WebhookValidatorInterface
{
    public function validate(Webhook $webhook) : bool;
}