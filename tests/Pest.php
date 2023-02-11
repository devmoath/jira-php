<?php

use Jira\Client;
use Jira\Contracts\Transporter;
use Jira\Enums\Transporter\Method;
use Jira\ValueObjects\BasicAuthentication;
use Jira\ValueObjects\Transporter\BaseUri;
use Jira\ValueObjects\Transporter\Headers;
use Jira\ValueObjects\Transporter\Payload;

function mockClient(Method $method, string $uri, mixed $response = null, $function = 'request'): Client
{
    $transporter = Mockery::mock(Transporter::class);

    $transporter
        ->shouldReceive($function)
        ->once()
        ->withArgs(function (Payload $payload) use ($function, $uri, $method) {
            $baseUri = BaseUri::from('jira.domain.com');
            $headers = Headers::withAuthorization(BasicAuthentication::from('foo', 'bar'));

            $request = $payload->toRequest($baseUri, $headers);

            if ($function === 'requestContent') {
                return $request->getMethod() === $method->value && $request->getUri()->__toString() === $uri;
            }

            return $request->getMethod() === $method->value
                && $request->getUri()->getScheme() === 'https'
                && $request->getUri()->getHost() === 'jira.domain.com'
                && $request->getUri()->getPath() === "/rest/$uri";
        })->andReturn($response);

    return new Client($transporter);
}
