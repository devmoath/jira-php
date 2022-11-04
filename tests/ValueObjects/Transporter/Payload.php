<?php

use Jira\Enums\Transporter\ContentType;
use Jira\Enums\Transporter\Method;
use Jira\ValueObjects\BasicAuthentication;
use Jira\ValueObjects\Transporter\BaseUri;
use Jira\ValueObjects\Transporter\Headers;
use Jira\ValueObjects\Transporter\Payload;

it('can create valid GET payload', function () {
    $payload = Payload::create(
        uri: 'api/2/issues',
        query: ['expand' => 'history']
    );

    $request = $payload->toRequest(
        baseUri: BaseUri::from('jira.example.com'),
        headers: Headers::withAuthorization(BasicAuthentication::from('foo', 'bar'))
    );

    expect($request->getUri()->getScheme())->toBe('https')
        ->and($request->getUri()->getHost())->toBe('jira.example.com')
        ->and($request->getUri()->getPath())->toBe('/rest/api/2/issues')
        ->and($request->getUri()->getQuery())->toBe('expand=history')
        ->and($request->getBody()->getContents())->toBeEmpty()
        ->and($request->getHeader('Content-Type')[0])->toBe(ContentType::JSON->value);
});

it('can create valid POST payload with JSON as content/type', function () {
    $payload = Payload::create(
        uri: 'api/2/issues',
        method: Method::POST,
        body: ['project' => ['id' => 1]],
        query: ['expand' => 'something']
    );

    $request = $payload->toRequest(
        baseUri: BaseUri::from('jira.example.com'),
        headers: Headers::withAuthorization(BasicAuthentication::from('foo', 'bar'))
    );

    expect($request->getUri()->getScheme())->toBe('https')
        ->and($request->getUri()->getHost())->toBe('jira.example.com')
        ->and($request->getUri()->getPath())->toBe('/rest/api/2/issues')
        ->and($request->getUri()->getQuery())->toBe('expand=something')
        ->and($request->getBody()->getContents())->toBe(json_encode([
            'project' => ['id' => 1],
        ]))
        ->and($request->getHeader('Content-Type')[0])->toBe(ContentType::JSON->value);
});

it('can create valid POST payload with MULTIPART as content/type', function () {
    $payload = Payload::create(
        uri: 'api/2/issues',
        method: Method::POST,
        contentType: ContentType::MULTIPART,
        body: [
            [
                'name' => 'file',
                'contents' => 'hi',
                'filename' => 'hi.txt',
            ],
            [
                'name' => 'file',
                'contents' => 'hi again',
                'filename' => 'hi_again.txt',
            ],
        ]
    );

    $request = $payload->toRequest(
        baseUri: BaseUri::from('jira.example.com'),
        headers: Headers::withAuthorization(BasicAuthentication::from('foo', 'bar'))
    );

    expect($request->getUri()->getScheme())->toBe('https')
        ->and($request->getUri()->getHost())->toBe('jira.example.com')
        ->and($request->getUri()->getPath())->toBe('/rest/api/2/issues')
        ->and($request->getUri()->getQuery())->toBeEmpty()
        ->and($request->getBody()->getContents())->toContain(
            'Content-Disposition: form-data; name="file"; filename="hi.txt"',
            'Content-Disposition: form-data; name="file"; filename="hi_again.txt"',
        )
        ->and($request->getHeader('Content-Type')[0])->toStartWith(ContentType::MULTIPART->value);
});
