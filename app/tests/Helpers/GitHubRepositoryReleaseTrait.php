<?php

declare(strict_types=1);

namespace App\Tests\Helpers;

use App\Entity\RepositoryReleaseEntity;

trait GitHubRepositoryReleaseTrait
{
    private function mockRepositoryRelease(array $data): RepositoryReleaseEntity
    {
        $release = $this->createMock(RepositoryReleaseEntity::class);
        $release->method('getReleaseDate')
            ->willReturn(new \DateTime($data['published_at']) ?? null);
        $release->method('getRepository')
            ->willReturn($data['repository'] ?? null);

        return $release;
    }
}