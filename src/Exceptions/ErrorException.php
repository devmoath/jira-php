<?php

declare(strict_types=1);

namespace Jira\Exceptions;

use Exception;

final class ErrorException extends Exception
{
    /**
     * Creates a new Exception instance.
     *
     * @param  array<string|int, string>  $contents
     */
    public function __construct(private readonly array $contents)
    {
        parent::__construct($contents[0]);
    }

    /**
     * Returns the error message.
     */
    public function getErrorMessage(): string
    {
        return $this->getMessage();
    }

    /**
     * Returns the error content.
     *
     * @return array<string|int, string>
     */
    public function getErrorContent(): array
    {
        return $this->contents;
    }
}
