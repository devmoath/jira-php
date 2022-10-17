<?php

declare(strict_types=1);

namespace Jira\ValueObjects\Transporter;

use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Jira\Enums\Transporter\ContentType;
use Jira\Enums\Transporter\Method;
use Jira\ValueObjects\ResourceUri;

/**
 * @internal
 */
final class Payload
{
    /**
     * Creates a new Request value object.
     *
     * @param  array<string, mixed>  $parameters
     */
    private function __construct(
        private readonly ContentType $contentType,
        private readonly Method $method,
        private readonly ResourceUri $uri,
        private readonly array $parameters = [],
    ) {
        // ..
    }

    /**
     * Creates a new Request value object.
     *
     * @param  array<string, mixed>  $parameters
     */
    public static function create(ContentType $contentType, Method $method, ResourceUri $uri, array $parameters = []): self
    {
        return new self(
            contentType: $contentType,
            method: $method,
            uri: $uri,
            parameters: $parameters,
        );
    }

    /**
     * Creates a new Psr 7 Request instance.
     *
     * @throws \JsonException
     */
    public function toRequest(BaseUri $baseUri, Headers $headers): Psr7Request
    {
        $body = null;
        $uri = "$baseUri/$this->uri";

        $headers = $headers->withContentType($this->contentType);

        if (in_array(needle: $this->method, haystack: [Method::POST, Method::PUT], strict: true)) {
            if ($this->contentType === ContentType::MULTIPART) {
                $body = new MultipartStream($this->parameters);

                $headers = $headers->withContentType($this->contentType, '; boundary='.$body->getBoundary());
            } else {
                $body = json_encode($this->parameters, JSON_THROW_ON_ERROR);
            }
        }

        if ($this->method === Method::GET && ! empty($this->parameters)) {
            $uri .= '?'.http_build_query($this->parameters);
        }

        return new Psr7Request($this->method->value, $uri, $headers->toArray(), $body);
    }
}
