<?php

declare(strict_types=1);

namespace Jira;

use Jira\Contracts\Transporter;
use Jira\Resources\Attachments;
use Jira\Resources\Customers;
use Jira\Resources\Groups;
use Jira\Resources\Issues;
use Jira\Resources\Projects;
use Jira\Resources\Requests;
use Jira\Resources\Users;

class Client
{
    public function __construct(private readonly Transporter $transporter)
    {
        //
    }

    public function attachments(): Attachments
    {
        return new Attachments(transporter: $this->transporter);
    }

    public function customers(): Customers
    {
        return new Customers(transporter: $this->transporter);
    }

    public function groups(): Groups
    {
        return new Groups(transporter: $this->transporter);
    }

    public function issues(): Issues
    {
        return new Issues(transporter: $this->transporter);
    }

    public function requests(): Requests
    {
        return new Requests(transporter: $this->transporter);
    }

    public function users(): Users
    {
        return new Users(transporter: $this->transporter);
    }

    public function projects(): Projects
    {
        return new Projects(transporter: $this->transporter);
    }
}
