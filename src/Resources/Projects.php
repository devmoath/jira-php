<?php

declare(strict_types=1);

namespace Jira\Resources;

use Jira\ValueObjects\Transporter\Payload;

class Projects
{
    use Concerns\Transportable;

    /**
     * Returns all projects which are visible for the currently logged in user.
     * If no user is logged in, it returns the list of projects that are visible
     * when using anonymous access.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/project-getAllProjects
     *
     * @param  array<array-key, mixed>  $query
     * @return non-empty-array<array-key, mixed>
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function getAll(array $query = []): array
    {
        $payload = Payload::create(
            uri: 'api/2/project',
            query: $query,
        );

        // @phpstan-ignore-next-line
        return $this->transporter->request(payload: $payload);
    }

    /**
     * Contains a full representation of a project in JSON format.
     *
     * All project keys associated with the project will only be returned if expand=projectKeys.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/project-getProject
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
            uri: "api/2/project/$id",
            query: $query,
        );

        // @phpstan-ignore-next-line
        return $this->transporter->request(payload: $payload);
    }
}
