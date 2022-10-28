<?php

use Jira\Client;
use Jira\Contracts\Transporter;
use Jira\Enums\Transporter\Method;
use Jira\Transporters\HttpTransporter;
use Jira\ValueObjects\BasicAuthentication;
use Jira\ValueObjects\ResourceUri;
use Jira\ValueObjects\Transporter\BaseUri;
use Jira\ValueObjects\Transporter\Headers;
use Jira\ValueObjects\Transporter\Payload;
use Mockery\MockInterface;
use Psr\Http\Client\ClientInterface;

/**
 * @return array{0: MockInterface&ClientInterface, 1: HttpTransporter}
 */
function mockHttpTransporter(): array
{
    $client = Mockery::mock(ClientInterface::class);

    return [
        $client,
        new HttpTransporter(
            client: $client,
            baseUri: BaseUri::from('jira.domain.com'),
            headers: Headers::withAuthorization(BasicAuthentication::from('foo', 'bar')),
        ),
    ];
}

function mockClient(Method $method, ResourceUri $uri, ?array $response): Client
{
    $transporter = Mockery::mock(Transporter::class);

    $transporter
        ->shouldReceive('request')
        ->once()
        ->withArgs(function (Payload $payload) use ($uri, $method) {
            $baseUri = BaseUri::from('jira.domain.com');
            $headers = Headers::withAuthorization(BasicAuthentication::from('foo', 'bar'));

            $request = $payload->toRequest($baseUri, $headers);

            return $request->getMethod() === $method->value
                && $request->getUri()->getScheme() === 'https'
                && $request->getUri()->getHost() === 'jira.domain.com'
                && $request->getUri()->getPath() === "/rest/$uri";
        })->andReturn($response);

    return new Client($transporter);
}
