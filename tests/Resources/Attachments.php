<?php

use Jira\Enums\Transporter\Method;

it('can get an attachment', function () {
    $client = mockClient(
        method: Method::GET,
        uri: 'api/2/attachment/1000',
        response: retrieveAttachment()
    );

    $result = $client->attachments()->get(id: '1000');

    expect($result)->toBe(retrieveAttachment());
});

it('can remove an attachment', function () {
    $client = mockClient(
        method: Method::DELETE,
        uri: 'api/2/attachment/1000',
    );

    $result = $client->attachments()->remove(id: '1000');

    expect($result)->toBeNull();
});

it('can download an attachment content', function () {
    $client = mockClient(
        method: Method::GET,
        uri: 'https://www.example.com/secure/attachment/4157499/index-1.json',
        response: downloadAttachment(),
        function: 'requestContent'
    );

    $result = $client->attachments()->download(url: 'https://www.example.com/secure/attachment/4157499/index-1.json');

    expect($result)->toBe(downloadAttachment());
});
