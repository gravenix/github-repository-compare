<?php

declare(strict_types=1);

namespace App\Tests\Helpers;

use App\Entity\RepositoryEntity;
use PHPUnit\Framework\MockObject\MockObject;

trait GitHubRepositoryTrait
{
    private function mockRepository(array $data): MockObject
    {
        $repo = $this->createMock(RepositoryEntity::class);
        $repo->method('getName')
            ->willReturn($data['name']);
        $repo->method('getStars')
            ->willReturn($data['stars'] ?? 0);
        $repo->method('getWatchers')
            ->willReturn($data['watchers'] ?? 0);
        $repo->method('getOpenedIssues')
            ->willReturn($data['openedIssues'] ?? 0);

        return $repo;
    }
}