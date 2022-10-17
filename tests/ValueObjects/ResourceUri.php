<?php

use Jira\ValueObjects\ResourceUri;

it('can create uri', function () {
    $uri = ResourceUri::create('api/2/issues');

    expect((string) $uri)->toBe('api/2/issues');
});
