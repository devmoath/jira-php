<?php

use Jira\Enums\Transporter\ContentType;
use Jira\Enums\Transporter\Method;
use Jira\ValueObjects\BasicAuthentication;
use Jira\ValueObjects\ResourceUri;
use Jira\ValueObjects\Transporter\BaseUri;
use Jira\ValueObjects\Transporter\Headers;
use Jira\ValueObjects\Transporter\Payload;

it('has a method', function () {
    $payload = new Payload(
        contentType: ContentType::JSON,
        method: Method::POST,
        uri: new ResourceUri('api/2/issues')
    );

    $baseUri = BaseUri::from('jira.example.com');
    $headers = Headers::withAuthorization(BasicAuthentication::from('foo', 'bar'))->withContentType(ContentType::JSON);

    expect($payload->toRequest($baseUri, $headers)->getMethod())->toBe('POST');
});

it('has a uri', function () {
    $payload = new Payload(
        contentType: ContentType::JSON,
        method: Method::GET,
        uri: new ResourceUri('api/2/issues')
    );

    $baseUri = BaseUri::from('jira.example.com');
    $headers = Headers::withAuthorization(BasicAuthentication::from('foo', 'bar'))->withContentType(ContentType::JSON);

    $uri = $payload->toRequest($baseUri, $headers)->getUri();

    expect($uri->getHost())->toBe('jira.example.com')
        ->and($uri->getScheme())->toBe('https')
        ->and($uri->getPath())->toBe('/rest/api/2/issues');
});

test('get verb does not have a body', function () {
    $payload = new Payload(
        contentType: ContentType::JSON,
        method: Method::GET,
        uri: new ResourceUri('api/2/issues')
    );

    $baseUri = BaseUri::from('jira.example.com');
    $headers = Headers::withAuthorization(BasicAuthentication::from('foo', 'bar'))->withContentType(ContentType::JSON);

    expect($payload->toRequest($baseUri, $headers)->getBody()->getContents())->toBe('');
});

test('post verb has a body', function () {
    $payload = new Payload(
        contentType: ContentType::JSON,
        method: Method::POST,
        uri: new ResourceUri('api/2/issues'),
        parameters: [
            'name' => 'test',
        ]
    );

    $baseUri = BaseUri::from('jira.example.com');
    $headers = Headers::withAuthorization(BasicAuthentication::from('foo', 'bar'))->withContentType(ContentType::JSON);

    expect($payload->toRequest($baseUri, $headers)->getBody()->getContents())->toBe(json_encode([
        'name' => 'test',
    ]));
});

test('builds upload request', function () {
    $payload = new Payload(
        contentType: ContentType::MULTIPART,
        method: Method::POST,
        uri: new ResourceUri('api/2/issues'),
        parameters: [
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

    $baseUri = BaseUri::from('jira.example.com');
    $headers = Headers::withAuthorization(BasicAuthentication::from('foo', 'bar'));

    $request = $payload->toRequest($baseUri, $headers);

    expect($request->getHeader('Content-Type')[0])
        ->toStartWith('multipart/form-data; boundary=')
        ->and($request->getBody()->getContents())
        ->toContain('Content-Disposition: form-data; name="file"; filename="hi.txt"')
        ->toContain('Content-Disposition: form-data; name="file"; filename="hi_again.txt"')
        ->toContain('hi')
        ->toContain('hi again');
});
