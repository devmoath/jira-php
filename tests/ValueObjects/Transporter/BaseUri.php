<?php

use Jira\ValueObjects\Transporter\BaseUri;

it('can be created from a string', function () {
    $baseUri = BaseUri::from('jira.example.com');

    expect((string) $baseUri)->toBe('https://jira.example.com/rest/');
});
