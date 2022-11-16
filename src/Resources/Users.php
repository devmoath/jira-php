<?php

declare(strict_types=1);

namespace Jira\Resources;

use Jira\Enums\Transporter\Method;
use Jira\ValueObjects\Transporter\Payload;

final class Users
{
    use Concerns\Transportable;

    /**
     * Modify user.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/user-updateUser
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
    public function update(array $body, array $query = []): array
    {
        $payload = Payload::create(
            uri: 'api/2/user',
            method: Method::PUT,
            body: $body,
            query: $query
        );

        // @phpstan-ignore-next-line
        return $this->transporter->request(payload: $payload);
    }

    /**
     * Create user.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/user-createUser
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
            uri: 'api/2/user',
            method: Method::POST,
            body: $body
        );

        // @phpstan-ignore-next-line
        return $this->transporter->request(payload: $payload);
    }

    /**
     * Remove user and its references (like project roles associations, watches, history).
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/user-removeUser
     *
     * @param  non-empty-array<array-key, mixed>  $query
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function remove(array $query): void
    {
        $payload = Payload::create(
            uri: 'api/2/user',
            method: Method::DELETE,
            query: $query
        );

        $this->transporter->request(payload: $payload);
    }

    /**
     * Return a user.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/user-getUser
     *
     * @param  non-empty-array<array-key, mixed>  $query
     * @return non-empty-array<array-key, mixed>
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function get(array $query): array
    {
        $payload = Payload::create(
            uri: 'api/2/user',
            query: $query
        );

        // @phpstan-ignore-next-line
        return $this->transporter->request(payload: $payload);
    }
}
