<?php

declare(strict_types=1);

namespace exception;

/**
 * Class WebhookDeliveryException
 *
 * This class represents an exception that occurs when there is a problem delivering a webhook.
 * It extends the built-in \RuntimeException class.
 */
class WebhookDeliveryException extends \RuntimeException
{
    // The class does not contain any additional methods or properties,
    // as it is used solely for indicating that a webhook delivery failure has occurred.
}
