<?php

declare(strict_types=1);

namespace Jira\ValueObjects;

use Stringable;

final class BasicAuthentication implements Stringable
{
    private function __construct(private readonly string $username, private readonly string $password)
    {
        // ..
    }

    public static function from(string $username, string $password): self
    {
        return new self(username: $username, password: $password);
    }

    public function __toString(): string
    {
        return 'Basic '.base64_encode(string: "$this->username:$this->password");
    }
}
