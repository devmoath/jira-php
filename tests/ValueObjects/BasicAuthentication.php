<?php

use Jira\ValueObjects\BasicAuthentication;

it('can be created from a string', function () {
    $basicAuthentication = BasicAuthentication::from('foo', 'bar');

    expect((string) $basicAuthentication)->toBe('Basic '.base64_encode('foo:bar'));
});
