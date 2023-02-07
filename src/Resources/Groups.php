<?php

declare(strict_types=1);

namespace Jira\Resources;

use Jira\Enums\Transporter\Method;
use Jira\ValueObjects\Transporter\Payload;

class Groups
{
    use Concerns\Transportable;

    /**
     * Create a group by given group parameter.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/group-createGroup
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
            uri: 'api/2/group',
            method: Method::POST,
            body: $body,
        );

        // @phpstan-ignore-next-line
        return $this->transporter->request(payload: $payload);
    }

    /**
     * Delete a group by given group parameter.
     *
     * @param  non-empty-array<array-key, mixed>  $query
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/group-removeGroup
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function remove(array $query): void
    {
        $payload = Payload::create(
            uri: 'api/2/group',
            method: Method::DELETE,
            query: $query
        );

        $this->transporter->request(payload: $payload);
    }

    /**
     * Return a paginated list of users who are members of the specified group and its subgroups.
     *
     * @param  non-empty-array<array-key, mixed>  $query
     * @return non-empty-array<array-key, mixed>
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/group-getUsersFromGroup
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function getUsers(array $query): array
    {
        $payload = Payload::create(
            uri: 'api/2/group/member',
            query: $query
        );

        // @phpstan-ignore-next-line
        return $this->transporter->request(payload: $payload);
    }

    /**
     * Add given user to a group.
     *
     * @param  non-empty-array<array-key, mixed>  $body
     * @param  non-empty-array<array-key, mixed>  $query
     * @return non-empty-array<array-key, mixed>
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/group-addUserToGroup
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function addUser(array $body, array $query): array
    {
        $payload = Payload::create(
            uri: 'api/2/group/user',
            method: Method::POST,
            body: $body,
            query: $query,
        );

        // @phpstan-ignore-next-line
        return $this->transporter->request(payload: $payload);
    }

    /**
     * Remove given user from a group.
     *
     * @param  non-empty-array<array-key, mixed>  $query
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/group-removeUserFromGroup
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function removeUser(array $query): void
    {
        $payload = Payload::create(
            uri: 'api/2/group/user',
            method: Method::DELETE,
            query: $query
        );

        $this->transporter->request(payload: $payload);
    }
}
