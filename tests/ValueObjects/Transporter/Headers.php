<?php

use Jira\Enums\Transporter\ContentType;
use Jira\ValueObjects\BasicAuthentication;
use Jira\ValueObjects\Transporter\Headers;

it('can be created from a Basic Authentication', function () {
    $headers = Headers::withAuthorization(BasicAuthentication::from('foo', 'bar'));

    expect($headers->toArray())->toBe([
        'Authorization' => 'Basic '.base64_encode('foo:bar'),
        'X-ExperimentalApi' => 'opt-in',
        'X-Atlassian-Token' => 'no-check',
    ]);
});

it('can have content/type', function () {
    $headers = Headers::withAuthorization(BasicAuthentication::from('foo', 'bar'))
        ->withContentType(ContentType::JSON);

    expect($headers->toArray())->toBe([
        'Authorization' => 'Basic '.base64_encode('foo:bar'),
        'X-ExperimentalApi' => 'opt-in',
        'X-Atlassian-Token' => 'no-check',
        'Content-Type' => 'application/json',
    ]);
});
