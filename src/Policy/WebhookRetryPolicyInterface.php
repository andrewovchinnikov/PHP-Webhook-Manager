<?php

declare(strict_types=1);

namespace WebhookManager\Policy;

use Exception;
use WebhookManager\Webhook\Webhook;

/**
 * Interface for webhook retry policy.
 *
 * This interface defines the method that must be implemented by a class that wants to handle the retry logic for failed webhook requests.
 */
interface WebhookRetryPolicyInterface
{
    /**
     * Determines whether a failed webhook request should be retried.
     *
     * @param Webhook   $webhook   The webhook object that contains information about the failed request.
     * @param Exception $exception The exception object that was thrown during the failed request.
     *
     * @return bool True if the request should be retried, false otherwise.
     */
    public function shouldRetry(Webhook $webhook, Exception $exception) : bool;
}
