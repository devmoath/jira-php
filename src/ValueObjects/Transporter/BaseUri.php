<?php

declare(strict_types=1);

namespace Jira\ValueObjects\Transporter;

use Stringable;

/**
 * @internal
 */
final class BaseUri implements Stringable
{
    /**
     * Creates a new Base URI value object.
     */
    private function __construct(private readonly string $baseUri)
    {
        // ..
    }

    /**
     * Creates a new Base URI value object.
     */
    public static function from(string $host): self
    {
        return new self(baseUri: "https://$host/rest");
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return $this->baseUri;
    }
}
