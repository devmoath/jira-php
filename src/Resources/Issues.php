<?php

declare(strict_types=1);

namespace Jira\Resources;

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
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function create(array $parameters): array
    {
        $payload = Payload::create('issue', $parameters);

        /** @var array{id: string, key: string, self: string} $result */
        $result = $this->transporter->request($payload);

        return $result;
    }

    /**
     * Lists the currently available issues, and provides information about each one.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/search-search
     *
     * @param  array<string, string>  $parameters
     * @return array{expand: string, startAt: int, maxResults: int, total: int, issues: array<int, array<string, mixed>>}
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function list(array $parameters = []): array
    {
        $payload = Payload::list('search', $parameters);

        /** @var array{expand: string, startAt: int, maxResults: int, total: int, issues: array<int, array<string, mixed>>} $result */
        $result = $this->transporter->request($payload);

        return $result;
    }

    /**
     * Returns information about a specific issue.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/issue-getIssue
     *
     * @param  array<string, string>  $parameters
     * @return array{expand: string, id: string, self: string, key: string, fields: array<string, mixed>}
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function retrieve(string $key, array $parameters = []): array
    {
        $payload = Payload::retrieve('issue', $key);

        /** @var array{expand: string, id: string, self: string, key: string, fields: array<string, mixed>} $result */
        $result = $this->transporter->request($payload);

        return $result;
    }
}
