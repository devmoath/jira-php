<?php

declare(strict_types=1);

namespace Jira;

use Jira\Contracts\Transporter;
use Jira\Resources\Issues;

final class Client
{
    /**
     * Creates a Client instance with the given credential.
     */
    public function __construct(private readonly Transporter $transporter)
    {
        // ..
    }

    /**
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/issue
     */
    public function issues(): Issues
    {
        return new Issues($this->transporter);
    }
}
