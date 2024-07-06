<?php

declare(strict_types=1);

namespace WebhookManager;

/**
 * Interface WebhookHeadersInterface
 *
 * This interface extends the built-in ArrayAccess interface and defines the methods that must be implemented by
 * classes that implement this interface.
 *
 * Classes that implement this interface will be used to manage headers for webhook requests.
 */
interface WebhookHeadersInterface extends \ArrayAccess
{
    // No methods are defined in this interface as it only extends the ArrayAccess interface
}
