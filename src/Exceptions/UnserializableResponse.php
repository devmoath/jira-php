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
    public function __construct(JsonException $jsonException)
    {
        parent::__construct($jsonException->getMessage(), 0, $jsonException);
    }
}
