<?php

declare(strict_types=1);

namespace Jira\Resources;

use Jira\Enums\Transporter\ContentType;
use Jira\Enums\Transporter\Method;
use Jira\ValueObjects\ResourceUri;
use Jira\ValueObjects\Transporter\Payload;

final class Issues
{
    use Concerns\Transportable;

    /**
     * Creates new issue for the provided parameters.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/issue-createIssue
     *
     * @param  array<string, mixed>  $parameters
     * @return array{id: string, key: string, self: string}
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function create(array $parameters): array
    {
        $payload = new Payload(
            contentType: ContentType::JSON,
            method: Method::POST,
            uri: new ResourceUri('api/2/issue'),
            parameters: $parameters,
        );

        /** @var array{id: string, key: string, self: string} $result */
        $result = $this->transporter->request($payload);

        return $result;
    }

    /**
     * Lists the currently available issues, and provides information about each one.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/search-search
     *
     * @param  array{jql?: string, startAt?: int, maxResults?: int, validateQuery?: bool, fields?: string, expand?: string}  $parameters
     * @return array{expand: string, startAt: int, maxResults: int, total: int, issues: array<int, array<string, mixed>>}
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function list(array $parameters = []): array
    {
        $payload = new Payload(
            contentType: ContentType::JSON,
            method: Method::GET,
            uri: new ResourceUri('api/2/search'),
            parameters: $parameters,
        );

        /** @var array{expand: string, startAt: int, maxResults: int, total: int, issues: array<int, array<string, mixed>>} $result */
        $result = $this->transporter->request($payload);

        return $result;
    }

    /**
     * Returns information about a specific issue.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/issue-getIssue
     *
     * @param  array{fields?: string, expand?: string, properties?: string, updateHistory?: bool}  $parameters
     * @return array{expand: string, id: string, self: string, key: string, fields: array<string, mixed>}
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function retrieve(string $key, array $parameters = []): array
    {
        $payload = new Payload(
            contentType: ContentType::JSON,
            method: Method::GET,
            uri: new ResourceUri("api/2/issue/$key"),
            parameters: $parameters,
        );

        /** @var array{expand: string, id: string, self: string, key: string, fields: array<string, mixed>} $result */
        $result = $this->transporter->request($payload);

        return $result;
    }

    /**
     * Edit information about a specific issue.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/issue-editIssue
     *
     * @param  array<string, mixed>  $parameters
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function edit(string $key, array $parameters = []): void
    {
        $payload = new Payload(
            contentType: ContentType::JSON,
            method: Method::PUT,
            uri: new ResourceUri("api/2/issue/$key"),
            parameters: $parameters,
        );

        $this->transporter->request($payload);
    }

    /**
     * Perform a transition on a specific issue.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/issue-doTransition
     *
     * @param  array<string, mixed>  $parameters
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function transition(string $key, array $parameters = []): void
    {
        $payload = new Payload(
            contentType: ContentType::JSON,
            method: Method::POST,
            uri: new ResourceUri("api/2/issue/$key/transitions"),
            parameters: $parameters,
        );

        $this->transporter->request($payload);
    }

    /**
     * Attach a file to a specific issue.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/issue/{issueIdOrKey}/attachments-addAttachment
     *
     * @param  array<string, mixed>  $parameters
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function attach(string $key, array $parameters = []): void
    {
        $payload = new Payload(
            contentType: ContentType::MULTIPART,
            method: Method::POST,
            uri: new ResourceUri("api/2/issue/$key/attachments"),
            parameters: $parameters,
        );

        $this->transporter->request($payload);
    }
}
