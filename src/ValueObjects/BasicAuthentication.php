<?php

declare(strict_types=1);

namespace Jira\ValueObjects;

use Stringable;

final class BasicAuthentication implements Stringable
{
    private function __construct(public readonly string $username, public readonly string $password)
    {
        // ..
    }

    public static function from(string $username, string $password): self
    {
        return new self($username, $password);
    }

    public function __toString(): string
    {
        return "$this->username:$this->password";
    }
}
