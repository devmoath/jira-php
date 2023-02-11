<?php

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Response;
use Jira\Exceptions\ErrorException;
use Jira\Exceptions\TransporterException;
use Jira\Exceptions\UnserializableResponse;
use Jira\Transporters\HttpTransporter;
use Jira\ValueObjects\BasicAuthentication;
use Jira\ValueObjects\Transporter\BaseUri;
use Jira\ValueObjects\Transporter\Headers;
use Jira\ValueObjects\Transporter\Payload;
use Psr\Http\Client\ClientInterface;

beforeEach(function () {
    $this->client = Mockery::mock(ClientInterface::class);

    $this->http = new HttpTransporter(
        client: $this->client,
        baseUri: BaseUri::from('jira.domain.com'),
        headers: Headers::withAuthorization(BasicAuthentication::from('foo', 'bar')),
    );
});

it('can send valid request and receive valid response', function () {
    $this->client->shouldReceive('sendRequest')
        ->once()
        ->andReturn(new Response(body: json_encode([])));

    $this->http->request(payload: Payload::create(uri: 'api/2/issues'));
});

it('can send valid request and receive no-content response', function () {
    $this->client->shouldReceive('sendRequest')
        ->once()
        ->andReturn(new Response(status: 204));

    $this->http->request(payload: Payload::create(uri: 'api/2/issues'));
});

it('can send valid request and receive invalid response (errorMessage)', function (string $function) {
    $this->client->shouldReceive('sendRequest')
        ->once()
        ->andReturn(new Response(status: 400, body: json_encode(errorMessage())));

    $this->http->{$function}(payload: Payload::create(uri: 'api/2/issues'));
})
    ->with('functions')
    ->throws(ErrorException::class, errorMessage()['errorMessage'], 0);

it('can send valid request and receive invalid response (errorMessages)', function (string $function) {
    $this->client->shouldReceive('sendRequest')
        ->once()
        ->andReturn(new Response(status: 400, body: json_encode(errorMessages())));

    $this->http->{$function}(payload: Payload::create(uri: 'api/2/issues'));
})
    ->with('functions')
    ->throws(ErrorException::class, errorMessages()['errorMessages'][0], 0);

it('can send valid request and receive invalid response (errors)', function (string $function) {
    $this->client->shouldReceive('sendRequest')
        ->once()
        ->andReturn(new Response(status: 400, body: json_encode(errors())));

    $this->http->{$function}(payload: Payload::create(uri: 'api/2/issues'));
})
    ->with('functions')
    ->throws(ErrorException::class, errors()['errors']['customfield_18208'], 0);

it('can send valid request and receive invalid response (syntax)', function () {
    $this->client->shouldReceive('sendRequest')
        ->once()
        ->andReturn(new Response(status: 400, body: 'error'));

    $this->http->request(payload: Payload::create(uri: 'api/2/issues'));
})->throws(UnserializableResponse::class, 'Syntax error', 0);

it('will fail because of a client errors', function (string $function) {
    $payload = Payload::create(
        uri: 'api/2/issues',
    );

    $this->client->shouldReceive('sendRequest')
        ->once()
        ->andThrow(
            exception: new ConnectException(
                message: 'Could not resolve host.',
                request: $payload->toRequest(
                    baseUri: BaseUri::from('jira.example.com'),
                    headers: Headers::withAuthorization(BasicAuthentication::from('foo', 'bar')),
                )
            )
        );

    $this->http->{$function}(payload: $payload);
})
    ->with('functions')
    ->throws(TransporterException::class, 'Could not resolve host.', 0);

it('can send valid requestContent and receive valid response', function () {
    $this->client->shouldReceive('sendRequest')
        ->once()
        ->andReturn(new Response(body: ''));

    $this->http->requestContent(payload: Payload::create(uri: 'https://www.example.com/jira/attachments/10000', query: ['a' => 'b']));
});
