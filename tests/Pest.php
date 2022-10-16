<?php

use Jira\Client;
use Jira\Contracts\Transporter;
use Jira\ValueObjects\BasicAuthentication;
use Jira\ValueObjects\Transporter\BaseUri;
use Jira\ValueObjects\Transporter\Headers;
use Jira\ValueObjects\Transporter\Payload;

/**
 * @param  array<int, mixed>  $params
 * @param  array<int, mixed>|string  $response
 */
function mockClient(
    string $method,
    string $resource,
    array $params,
    array|string $response,
): Client {
    $transporter = Mockery::mock(Transporter::class);

    $transporter
        ->shouldReceive('request')
        ->once()
        ->withArgs(function (Payload $payload) use ($method, $resource) {
            $baseUri = BaseUri::from('jira.example.com');
            $headers = Headers::withAuthorization(BasicAuthentication::from('foo', 'bar'));

            $request = $payload->toRequest($baseUri, $headers);

            return $request->getMethod() === $method
                && $request->getUri()->getPath() === "/rest/$resource";
        })->andReturn($response);

    return new Client($transporter);
}
