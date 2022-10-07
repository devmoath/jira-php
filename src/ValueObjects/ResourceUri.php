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

    /**
     * Creates a new ResourceUri value object that creates the given resource.
     */
    public static function create(string $resource): self
    {
        return new self($resource);
    }

    /**
     * Creates a new ResourceUri value object that uploads to the given resource.
     */
    public static function upload(string $resource): self
    {
        return new self($resource);
    }

    /**
     * Creates a new ResourceUri value object that lists the given resource.
     */
    public static function list(string $resource): self
    {
        return new self($resource);
    }

    /**
     * Creates a new ResourceUri value object that retrieves the given resource.
     */
    public static function retrieve(string $resource, string $id): self
    {
        return new self("$resource/$id");
    }

    /**
     * Creates a new ResourceUri value object that retrieves the given resource.
     */
    public static function edit(string $resource, string $id): self
    {
        return new self("$resource/$id");
    }

    /**
     * Creates a new ResourceUri value object that retrieves the given resource.
     */
    public static function transition(string $resource, string $id): self
    {
        return new self("$resource/$id/transitions");
    }

    /**
     * Creates a new ResourceUri value object that deletes the given resource.
     */
    public static function delete(string $resource, string $id): self
    {
        return new self("$resource/$id");
    }

    /**
     * {@inheritDoc}
     */
    public function __toString(): string
    {
        return $this->uri;
    }
}
