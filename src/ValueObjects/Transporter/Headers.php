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
     * @param  array<string, string>  $headers
     */
    private function __construct(private readonly array $headers)
    {
        // ..
    }

    /**
     * Creates a new Headers value object with the given API token.
     */
    public static function withAuthorization(BasicAuthentication $basicAuthentication): self
    {
        return new self([
            'Authorization' => 'Basic '.base64_encode((string) $basicAuthentication),
        ]);
    }

    /**
     * Creates a new Headers value object, with the given content type, and the existing headers.
     */
    public function withContentType(ContentType $contentType, string $suffix = ''): self
    {
        return new self([
            ...$this->headers,
            'Content-Type' => $contentType->value.$suffix,
        ]);
    }

    /**
     * @return array<string, string> $headers
     */
    public function toArray(): array
    {
        return $this->headers;
    }
}
