<?php

declare(strict_types=1);

namespace Jira\ValueObjects\Transporter;

use Jira\Enums\Transporter\ContentType;
use Jira\ValueObjects\BasicAuthentication;

/**
 * @internal
 */
final class Headers
{
    /**
     * Creates a new Headers value object.
     *
     * @param  non-empty-array<string, string>  $headers
     */
    private function __construct(private readonly array $headers)
    {
        // ..
    }

    public static function withAuthorization(BasicAuthentication $basicAuthentication): self
    {
        return new self(headers: [
            'Authorization' => (string) $basicAuthentication,
            'X-ExperimentalApi' => 'opt-in',
            'X-Atlassian-Token' => 'no-check',
        ]);
    }

    public function withContentType(ContentType $contentType, string $suffix = ''): self
    {
        return new self(headers: [
            ...$this->headers,
            'Content-Type' => $contentType->value.$suffix,
        ]);
    }

    /**
     * @return non-empty-array<string, string>
     */
    public function toArray(): array
    {
        return $this->headers;
    }
}
