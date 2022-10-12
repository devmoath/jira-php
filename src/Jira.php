<?php

declare(strict_types=1);

use GuzzleHttp\Client as GuzzleClient;
use Jira\Client;
use Jira\Transporters\HttpTransporter;
use Jira\ValueObjects\BasicAuthentication;
use Jira\ValueObjects\Transporter\BaseUri;
use Jira\ValueObjects\Transporter\Headers;

final class Jira
{
    /**
     * Creates a new Jira Client with the given basic auth.
     */
    public static function client(string $username, string $password, string $host): Client
    {
        $basicAuthentication = BasicAuthentication::from($username, $password);

        $baseUri = BaseUri::from($host);

        $headers = Headers::withAuthorization($basicAuthentication);

        $client = new GuzzleClient();

        $transporter = new HttpTransporter($client, $baseUri, $headers);

        return new Client($transporter);
    }
}
