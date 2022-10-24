<?php

use GuzzleHttp\Psr7\Response;
use Jira\Enums\Transporter\ContentType;
use Jira\Enums\Transporter\Method;
use Jira\Exceptions\ErrorException;
use Jira\Exceptions\UnserializableResponse;
use Jira\ValueObjects\ResourceUri;
use Jira\ValueObjects\Transporter\Payload;

it('can send valid request and receive valid response', function () {
    [$client, $http] = mockHttpTransporter();

    $client->shouldReceive('sendRequest')
        ->once()
        ->andReturn(new Response(body: json_encode([])));

    $http->request(
        payload: Payload::create(
            contentType: ContentType::JSON,
            method: Method::GET,
            uri: ResourceUri::create('api/2/issues'),
        )
    );
});

it('can send valid request and receive invalid response (errorMessage)', function () {
    [$client, $http] = mockHttpTransporter();

    $client->shouldReceive('sendRequest')
        ->once()
        ->andReturn(new Response(status: 400, body: json_encode(errorMessage())));

    $http->request(
        payload: Payload::create(
            contentType: ContentType::JSON,
            method: Method::GET,
            uri: ResourceUri::create('api/2/issues'),
        )
    );
})->throws(ErrorException::class, errorMessage()['errorMessage'], 0);

it('can send valid request and receive invalid response (errorMessages)', function () {
    [$client, $http] = mockHttpTransporter();

    $client->shouldReceive('sendRequest')
        ->once()
        ->andReturn(new Response(status: 400, body: json_encode(errorMessages())));

    $http->request(
        payload: Payload::create(
            contentType: ContentType::JSON,
            method: Method::GET,
            uri: ResourceUri::create('api/2/issues'),
        )
    );
})->throws(ErrorException::class, errorMessages()['errorMessages'][0], 0);

it('can send valid request and receive invalid response (errors)', function () {
    [$client, $http] = mockHttpTransporter();

    $client->shouldReceive('sendRequest')
        ->once()
        ->andReturn(new Response(status: 400, body: json_encode(errors())));

    $http->request(
        payload: Payload::create(
            contentType: ContentType::JSON,
            method: Method::GET,
            uri: ResourceUri::create('api/2/issues'),
        )
    );
})->throws(ErrorException::class, errors()['errors']['customfield_18208'], 0);

it('can send valid request and receive invalid response (syntax)', function () {
    [$client, $http] = mockHttpTransporter();

    $client->shouldReceive('sendRequest')
        ->once()
        ->andReturn(new Response(status: 400, body: 'error'));

    $http->request(
        payload: Payload::create(
            contentType: ContentType::JSON,
            method: Method::GET,
            uri: ResourceUri::create('api/2/issues'),
        )
    );
})->throws(UnserializableResponse::class, 'Syntax error', 0);
