<?php

use Jira\Enums\Transporter\Method;
use Jira\ValueObjects\ResourceUri;

it('can retrieve an attachment', function () {
    $client = mockClient(
        method: Method::GET,
        uri: ResourceUri::create('api/2/attachment/1000'),
        response: retrieveAttachment()
    );

    $result = $client->attachments()->retrieve(id: '1000');

    expect($result)->toBe(retrieveAttachment());
});

it('can remove an attachment', function () {
    $client = mockClient(
        method: Method::DELETE,
        uri: ResourceUri::create('api/2/attachment/1000'),
        response: null
    );

    /** @noinspection PhpVoidFunctionResultUsedInspection */
    $result = $client->attachments()->remove(id: '1000');

    expect($result)->toBeNull();
});
