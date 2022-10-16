<?php

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Request as Psr7Request;
use GuzzleHttp\Psr7\Response;
use Jira\Enums\Transporter\ContentType;
use Jira\Enums\Transporter\Method;
use Jira\Exceptions\ErrorException;
use Jira\Exceptions\TransporterException;
use Jira\Exceptions\UnserializableResponse;
use Jira\Transporters\HttpTransporter;
use Jira\ValueObjects\BasicAuthentication;
use Jira\ValueObjects\ResourceUri;
use Jira\ValueObjects\Transporter\BaseUri;
use Jira\ValueObjects\Transporter\Headers;
use Jira\ValueObjects\Transporter\Payload;
use Psr\Http\Client\ClientInterface;

beforeEach(function () {
    $this->client = Mockery::mock(ClientInterface::class);

    $basicAuthentication = BasicAuthentication::from('foo', 'bar');

    $this->http = new HttpTransporter(
        $this->client,
        BaseUri::from('jira.example.com'),
        Headers::withAuthorization($basicAuthentication)->withContentType(ContentType::JSON),
    );
});

test('request', function () {
    $payload = new Payload(
        contentType: ContentType::JSON,
        method: Method::GET,
        uri: new ResourceUri('api/2/issues'),
    );

    $response = new Response(200, [], json_encode([]));

    $this->client
        ->shouldReceive('sendRequest')
        ->once()
        ->withArgs(function (Psr7Request $request) {
            expect($request->getMethod())->toBe('GET')
                ->and($request->getUri())
                ->getHost()->toBe('jira.example.com')
                ->getScheme()->toBe('https')
                ->getPath()->toBe('/rest/api/2/issues');

            return true;
        })->andReturn($response);

    $this->http->request($payload);
});

test('request server errors', function () {
    $payload = new Payload(
        contentType: ContentType::JSON,
        method: Method::GET,
        uri: new ResourceUri('api/2/issues'),
    );

    $response = new Response(401, [], json_encode([
        'errorMessages' => [
            'dummy',
        ],
    ]));

    $this->client
        ->shouldReceive('sendRequest')
        ->once()
        ->andReturn($response);

    expect(fn () => $this->http->request($payload))
        ->toThrow(function (ErrorException $e) {
            expect($e->getMessage())->toBe('dummy');
        });
});

test('request client errors', function () {
    $payload = new Payload(
        contentType: ContentType::JSON,
        method: Method::GET,
        uri: new ResourceUri('api/2/issues'),
    );

    $baseUri = BaseUri::from('api.openai.com');
    $headers = Headers::withAuthorization(BasicAuthentication::from('foo', 'bar'));

    $this->client
        ->shouldReceive('sendRequest')
        ->once()
        ->andThrow(new ConnectException('Could not resolve host.', $payload->toRequest($baseUri, $headers)));

    expect(fn () => $this->http->request($payload))->toThrow(function (TransporterException $e) {
        expect($e->getMessage())->toBe('Could not resolve host.')
            ->and($e->getCode())->toBe(0)
            ->and($e->getPrevious())->toBeInstanceOf(ConnectException::class);
    });
});

test('request serialization errors', function () {
    $payload = new Payload(
        contentType: ContentType::JSON,
        method: Method::GET,
        uri: new ResourceUri('api/2/issues'),
    );

    $response = new Response(200, [], 'err');

    $this->client
        ->shouldReceive('sendRequest')
        ->once()
        ->andReturn($response);

    $this->http->request($payload);
})->throws(UnserializableResponse::class, 'Syntax error');
