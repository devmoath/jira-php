<?php

declare(strict_types=1);

namespace Jira\Resources;

use Jira\Enums\Transporter\ContentType;
use Jira\Enums\Transporter\Method;
use Jira\ValueObjects\Transporter\Payload;

class Issues
{
    use Concerns\Transportable;

    /**
     * Create an issue or a sub-task from a JSON representation.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/issue-createIssue
     *
     * @param  non-empty-array<array-key, mixed>  $body
     * @return non-empty-array<array-key, mixed>
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function create(array $body): array
    {
        $payload = Payload::create(
            uri: 'api/2/issue',
            method: Method::POST,
            body: $body,
        );

        // @phpstan-ignore-next-line
        return $this->transporter->request(payload: $payload);
    }

    /**
     * Create issues or sub-tasks from a JSON representation.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/issue-createIssues
     *
     * @param  non-empty-array<array-key, mixed>  $body
     * @return non-empty-array<array-key, mixed>
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function bulk(array $body): array
    {
        $payload = Payload::create(
            uri: 'api/2/issue/bulk',
            method: Method::POST,
            body: $body,
        );

        // @phpstan-ignore-next-line
        return $this->transporter->request(payload: $payload);
    }

    /**
     * Return a full representation of the issue for the given issue key.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/issue-getIssue
     *
     * @param  array<array-key, mixed>  $query
     * @return non-empty-array<array-key, mixed>
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function get(int|string $id, array $query = []): array
    {
        $payload = Payload::create(
            uri: "api/2/issue/$id",
            query: $query,
        );

        // @phpstan-ignore-next-line
        return $this->transporter->request(payload: $payload);
    }

    /**
     * Delete an issue.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/issue-deleteIssue
     *
     * @param  array<array-key, mixed>  $query
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function delete(int|string $id, array $query = []): void
    {
        $payload = Payload::create(
            uri: "api/2/issue/$id",
            method: Method::DELETE,
            query: $query,
        );

        $this->transporter->request(payload: $payload);
    }

    /**
     * Edit an issue from a JSON representation.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/issue-editIssue
     *
     * @param  non-empty-array<array-key, mixed>  $body
     * @param  array<array-key, mixed>  $query
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function edit(int|string $id, array $body, array $query = []): void
    {
        $payload = Payload::create(
            uri: "api/2/issue/$id",
            method: Method::PUT,
            body: $body,
            query: $query,
        );

        $this->transporter->request(payload: $payload);
    }

    /**
     * Archive an issue.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/issue-archiveIssue
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function archive(int|string $id): void
    {
        $payload = Payload::create(
            uri: "api/2/issue/$id/archive",
            method: Method::PUT,
        );

        $this->transporter->request(payload: $payload);
    }

    /**
     * Assign an issue to a user.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/issue-assign
     *
     * @param  non-empty-array<array-key, mixed>  $body
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function assign(int|string $id, array $body): void
    {
        $payload = Payload::create(
            uri: "api/2/issue/$id/assignee",
            method: Method::PUT,
            body: $body,
        );

        $this->transporter->request(payload: $payload);
    }

    /**
     * Return all comments for an issue.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/issue-getComments
     *
     * @param  array<array-key, mixed>  $query
     * @return non-empty-array<array-key, mixed>
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function getComments(int|string $id, array $query = []): array
    {
        $payload = Payload::create(
            uri: "api/2/issue/$id/comment",
            query: $query,
        );

        // @phpstan-ignore-next-line
        return $this->transporter->request(payload: $payload);
    }

    /**
     * Add new comment to an issue.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/issue-addComment
     *
     * @param  non-empty-array<array-key, mixed>  $body
     * @param  array<array-key, mixed>  $query
     * @return non-empty-array<array-key, mixed>
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function addComment(int|string $id, array $body, array $query = []): array
    {
        $payload = Payload::create(
            uri: "api/2/issue/$id/comment",
            method: Method::POST,
            body: $body,
            query: $query,
        );

        // @phpstan-ignore-next-line
        return $this->transporter->request(payload: $payload);
    }

    /**
     * Update existing comment using its JSON representation.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/issue-updateComment
     *
     * @param  non-empty-array<array-key, mixed>  $body
     * @param  array<array-key, mixed>  $query
     * @return non-empty-array<array-key, mixed>
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function updateComment(int|string $id, int|string $commentId, array $body, array $query = []): array
    {
        $payload = Payload::create(
            uri: "api/2/issue/$id/comment/$commentId",
            method: Method::PUT,
            body: $body,
            query: $query,
        );

        // @phpstan-ignore-next-line
        return $this->transporter->request(payload: $payload);
    }

    /**
     * Delete an existing comment.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/issue-getComment
     *
     * @param  array<array-key, mixed>  $query
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function deleteComment(int|string $id, int|string $commentId, array $query = []): void
    {
        $payload = Payload::create(
            uri: "api/2/issue/$id/comment/$commentId",
            method: Method::DELETE,
            query: $query,
        );

        $this->transporter->request(payload: $payload);
    }

    /**
     * Return a single comment.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/issue-getComment
     *
     * @param  array<array-key, mixed>  $query
     * @return non-empty-array<array-key, mixed>
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function getComment(int|string $id, int|string $commentId, array $query = []): array
    {
        $payload = Payload::create(
            uri: "api/2/issue/$id/comment/$commentId",
            query: $query,
        );

        // @phpstan-ignore-next-line
        return $this->transporter->request(payload: $payload);
    }

    /**
     * Get a list of the transitions possible for this issue by the current user, along with fields that are required and their types.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/issue-getTransitions
     *
     * @param  array<array-key, mixed>  $query
     * @return non-empty-array<array-key, mixed>
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function getTransitions(int|string $id, array $query = []): array
    {
        $payload = Payload::create(
            uri: "api/2/issue/$id/transitions",
            query: $query,
        );

        // @phpstan-ignore-next-line
        return $this->transporter->request(payload: $payload);
    }

    /**
     * Perform a transition on an issue.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/issue-doTransition
     *
     * @param  non-empty-array<array-key, mixed>  $body
     * @param  array<array-key, mixed>  $query
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function doTransition(int|string $id, array $body, array $query = []): void
    {
        $payload = Payload::create(
            uri: "api/2/issue/$id/transitions",
            method: Method::POST,
            body: $body,
            query: $query
        );

        $this->transporter->request(payload: $payload);
    }

    /**
     * Add one or more attachments to an issue.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/issue/%7BissueIdOrKey%7D/attachments-addAttachment
     *
     * @param  non-empty-array<array-key, mixed>  $body
     * @return non-empty-array<array-key, mixed>
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function attach(int|string $id, array $body): array
    {
        $payload = Payload::create(
            uri: "api/2/issue/$id/attachments",
            method: Method::POST,
            contentType: ContentType::MULTIPART,
            body: $body,
        );

        // @phpstan-ignore-next-line
        return $this->transporter->request(payload: $payload);
    }

    /**
     * Search for issues using JQL.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/search-search
     *
     * @param  array<array-key, mixed>  $query
     * @return non-empty-array<array-key, mixed>
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function search(array $query = []): array
    {
        $payload = Payload::create(
            uri: 'api/2/search',
            query: $query
        );

        // @phpstan-ignore-next-line
        return $this->transporter->request(payload: $payload);
    }
}
