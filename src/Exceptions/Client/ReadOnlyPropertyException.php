<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Exceptions\Client;

use DnsMadeEasy\Exceptions\DnsMadeEasyException;

/**
 * Exception thrown when an attempt is made to set a read-only property on an API resource.
 *
 * @package DnsMadeEasy\Exceptions
 */
class ReadOnlyPropertyException extends DnsMadeEasyException
{
}
