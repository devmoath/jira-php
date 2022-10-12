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
    public function __construct(private readonly string $uri)
    {
        // ..
    }

    /**
     * {@inheritDoc}
     */
    public function __toString(): string
    {
        return $this->uri;
    }
}
