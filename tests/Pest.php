<?php

use Jira\Transporters\HttpTransporter;
use Jira\ValueObjects\BasicAuthentication;
use Jira\ValueObjects\Transporter\BaseUri;
use Jira\ValueObjects\Transporter\Headers;
use Mockery\MockInterface;
use Psr\Http\Client\ClientInterface;

/**
 * @return array{0: MockInterface, 1: HttpTransporter}
 */
function mockHttpTransporter(): array
{
    $client = Mockery::mock(ClientInterface::class);

    return [
        $client,
        new HttpTransporter(
            $client,
            BaseUri::from('jira.example.com'),
            Headers::withAuthorization(BasicAuthentication::from('foo', 'bar')),
        ),
    ];
}
