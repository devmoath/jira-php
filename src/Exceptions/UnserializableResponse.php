<?php

declare(strict_types=1);

namespace Jira\Exceptions;

use Exception;
use JsonException;

/**
 * @internal
 */
final class UnserializableResponse extends Exception
{
    public function __construct(JsonException $exception)
    {
        parent::__construct($exception->getMessage(), 0, $exception);
    }
}
