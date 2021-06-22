<?php

declare(strict_types=1);

namespace App\Api\Types;

use App\Entity\PullRequestCollection;
use App\Entity\RepositoryEntity;

interface RepositoryApiInterface 
{
    public function getRepository(string $repositoryName): RepositoryEntity;

    /**
     * @return array<RepositoryReleaseEntity>
     */
    public function getRepositoryReleases(string $repositoryName): array;

    public function getPullRequests(string $repositoryName): PullRequestCollection;
}