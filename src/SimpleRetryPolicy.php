<?php

declare(strict_types=1);

namespace WebhookManager;

/**
 * Class SimpleRetryPolicy
 *
 * Implements a simple retry policy for webhook delivery.
 * The policy will retry up to a maximum number of attempts.
 */
class SimpleRetryPolicy implements WebhookRetryPolicy
{
    /**
     * @var int $maxAttempts The maximum number of attempts to retry delivery.
     */
    private int $maxAttempts;

    /**
     * SimpleRetryPolicy constructor.
     *
     * @param int $maxAttempts The maximum number of attempts to retry delivery.
     */
    public function __construct(int $maxAttempts)
    {
        $this->maxAttempts = $maxAttempts;
    }

    /**
     * Determines whether the webhook delivery should be retried.
     *
     * @param Webhook    $webhook   The webhook object.
     * @param \Exception $exception The exception object that caused the delivery failure.
     *
     * @return bool True if the delivery should be retried, false otherwise.
     */
    public function shouldRetry(Webhook $webhook, \Exception $exception) : bool
    {
        // Get the current number of attempts.
        $attempts = $webhook->getAttempts() ?? 0;

        // Check if the number of attempts is less than the maximum number of attempts.
        return $attempts < $this->maxAttempts;
    }
}
