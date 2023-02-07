<?php

declare(strict_types=1);

use GuzzleHttp\Client as GuzzleClient;
use Jira\Client;
use Jira\Transporters\HttpTransporter;
use Jira\ValueObjects\BasicAuthentication;
use Jira\ValueObjects\Transporter\BaseUri;
use Jira\ValueObjects\Transporter\Headers;

class Jira
{
    public static function client(string $username, string $password, string $host): Client
    {
        $basicAuthentication = BasicAuthentication::from(username: $username, password: $password);

        $baseUri = BaseUri::from(host: $host);

        $headers = Headers::withAuthorization(basicAuthentication: $basicAuthentication);

        $client = new GuzzleClient();

        $httpTransporter = new HttpTransporter(client: $client, baseUri: $baseUri, headers: $headers);

        return new Client(transporter: $httpTransporter);
    }
}
