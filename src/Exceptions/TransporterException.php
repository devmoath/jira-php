<?php

declare(strict_types=1);

namespace Jira\Exceptions;

use Exception;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * @internal
 */
class TransporterException extends Exception
{
    public function __construct(ClientExceptionInterface $clientException)
    {
        parent::__construct($clientException->getMessage(), 0, $clientException);
    }
}
