<?php

declare(strict_types=1);

namespace Jira\Resources;

use Jira\ValueObjects\Transporter\Payload;

final class Issues
{
    use Concerns\Transportable;

    /**
     * Creates a completion for the provided prompt and parameters
     *
     * @see https://beta.openai.com/docs/api-reference/completions/create-completion
     *
     * @param  array<string, mixed>  $parameters
     * @return array<string, array<string, mixed>|string>
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function create(array $parameters): array
    {
        $payload = Payload::create('issue', $parameters);

        /** @var array<string, array<string, mixed>|string> $result */
        $result = $this->transporter->requestObject($payload);

        return $result;
    }

    /**
     * Creates a completion for the provided prompt and parameters
     *
     * @see https://beta.openai.com/docs/api-reference/completions/create-completion
     *
     * @return array<string, array<string, mixed>|string>
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function list(): array
    {
        $payload = Payload::list('search');

        /** @var array<string, array<string, mixed>|string> $result */
        $result = $this->transporter->requestObject($payload);

        return $result;
    }
}
