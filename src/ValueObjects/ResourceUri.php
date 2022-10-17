<?php

declare(strict_types=1);

namespace Jira\ValueObjects;

use Stringable;

/**
 * @internal
 */
final class ResourceUri implements Stringable
{
    /**
     * Creates a new ResourceUri value object.
     */
    private function __construct(private readonly string $uri)
    {
        // ..
    }

    public static function create(string $uri): self
    {
        return new self($uri);
    }

    /**
     * {@inheritDoc}
     */
    public function __toString(): string
    {
        return $this->uri;
    }
}
