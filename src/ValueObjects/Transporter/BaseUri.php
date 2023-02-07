<?php

declare(strict_types=1);

namespace Jira\ValueObjects\Transporter;

use Stringable;

/**
 * @internal
 */
class BaseUri implements Stringable
{
    private function __construct(private readonly string $baseUri)
    {
        // ..
    }

    public static function from(string $host): self
    {
        return new self(baseUri: "https://$host/rest/");
    }

    public function __toString(): string
    {
        return $this->baseUri;
    }
}
