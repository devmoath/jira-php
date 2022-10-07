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
     * Creates a new Payload value object from the given parameters.
     *
     * @param  array<string, string>  $parameters
     */
    public static function list(string $resource, array $parameters): self
    {
        $contentType = ContentType::JSON;
        $method = Method::GET;
        $uri = ResourceUri::list($resource);

        return new self($contentType, $method, $uri, $parameters);
    }

    /**
     * Creates a new Payload value object from the given parameters.
     *
     * @param  array<string, string>  $parameters
     */
    public static function retrieve(string $resource, string $id, array $parameters = []): self
    {
        $contentType = ContentType::JSON;
        $method = Method::GET;
        $uri = ResourceUri::retrieve($resource, $id);

        return new self($contentType, $method, $uri, $parameters);
    }

    /**
     * Creates a new Payload value object from the given parameters.
     *
     * @param  array<string, mixed>  $parameters
     */
    public static function edit(string $resource, string $id, array $parameters = []): self
    {
        $contentType = ContentType::JSON;
        $method = Method::PUT;
        $uri = ResourceUri::edit($resource, $id);

        return new self($contentType, $method, $uri, $parameters);
    }

    /**
     * Creates a new Payload value object from the given parameters.
     *
     * @param  array<string, mixed>  $parameters
     */
    public static function create(string $resource, array $parameters): self
    {
        $contentType = ContentType::JSON;
        $method = Method::POST;
        $uri = ResourceUri::create($resource);

        return new self($contentType, $method, $uri, $parameters);
    }

    /**
     * Creates a new Payload value object from the given parameters.
     *
     * @param  array<string, mixed>  $parameters
     */
    public static function transition(string $resource, string $id, array $parameters): self
    {
        $contentType = ContentType::JSON;
        $method = Method::POST;
        $uri = ResourceUri::transition($resource, $id);

        return new self($contentType, $method, $uri, $parameters);
    }

    /**
     * Creates a new Payload value object from the given parameters.
     *
     * @param  array<string, mixed>  $parameters
     */
    public static function upload(string $resource, array $parameters): self
    {
        $contentType = ContentType::MULTIPART;
        $method = Method::POST;
        $uri = ResourceUri::upload($resource);

        return new self($contentType, $method, $uri, $parameters);
    }

    /**
     * Creates a new Payload value object from the given parameters.
     */
    public static function delete(string $resource, string $id): self
    {
        $contentType = ContentType::JSON;
        $method = Method::DELETE;
        $uri = ResourceUri::delete($resource, $id);

        return new self($contentType, $method, $uri);
    }

    /**
     * Creates a new Psr 7 Request instance.
     *
     * @throws \JsonException
     */
    public function toRequest(BaseUri $baseUri, Headers $headers): Psr7Request
    {
        $body = null;
        $uri = "$baseUri$this->uri";

        $headers = $headers->withContentType($this->contentType);

        if (in_array(needle: $this->method, haystack: [Method::POST, Method::PUT], strict: true)) {
            if ($this->contentType === ContentType::MULTIPART) {
                $body = new MultipartStream(
                    array_map(
                        callback: fn ($key): array => ['name' => $key, 'contents' => $this->parameters[$key]],
                        array: array_keys($this->parameters)
                    )
                );

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
