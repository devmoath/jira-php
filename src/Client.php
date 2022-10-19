<?php

declare(strict_types=1);

namespace Jira;

use Jira\Contracts\Transporter;
use Jira\Resources\Attachments;
use Jira\Resources\Issues;
use Jira\Resources\ServiceDesk;

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
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/search-search
     */
    public function issues(): Issues
    {
        return new Issues($this->transporter);
    }

    /**
     * @see https://docs.atlassian.com/jira-servicedesk/REST/5.2.0
     */
    public function serviceDesk(): ServiceDesk
    {
        return new ServiceDesk($this->transporter);
    }

    /**
     * @see https://docs.atlassian.com/jira-servicedesk/REST/5.2.0
     */
    public function attachments(): Attachments
    {
        return new Attachments($this->transporter);
    }
}
