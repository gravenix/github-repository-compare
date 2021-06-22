<?php

namespace App\Entity;

class PullRequest implements Entity
{
    public static function fromData(array $data): PullRequest
    {
        // no need for now
        return new self();
    }
}