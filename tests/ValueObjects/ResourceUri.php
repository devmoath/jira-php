<?php

use Jira\ValueObjects\ResourceUri;

it('can create uri', function () {
    $uri = new ResourceUri('api/2/issues');

    expect((string) $uri)->toBe('api/2/issues');
});
