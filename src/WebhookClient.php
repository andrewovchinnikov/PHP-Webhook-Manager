<?php

declare(strict_types=1);

namespace WebhookManager;

class WebhookClient
{
    public function send(Webhook $webhook) : void
    {
        $data = http_build_query(['payload' => $webhook->getPayload()]);

        $options = [
            'http' => [
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $data,
            ],
        ];

        $context = stream_context_create($options);
        file_get_contents($webhook->getUrl(), false, $context);
    }
}
