<?php

declare(strict_types=1);

namespace App\Comparer;

use App\Entity\RepositoryEntity;
use App\Tests\Helpers\GitHubRepositoryTrait;
use PHPUnit\Framework\TestCase;

class RepositoryComparerTest extends TestCase
{
    use GitHubRepositoryTrait;

    private const KEYS = [
        'forks',
        'stars',
        'openedIssues',
    ];

    /**
     * @dataProvider provideRepositories
     */
    public function testCompare(RepositoryEntity $first, RepositoryEntity $second): void
    {
        $comparer = new RepositoryComparer();
        $result = $comparer->toJson([$first, $second]);

        static::assertIsArray($result);
        foreach (self::KEYS as $param) {
            static::assertArrayHasKey($param, $result);
            static::assertArrayHasKey($first->getName(), $result[$param]);
            static::assertArrayHasKey($second->getName(), $result[$param]);
        }
    }

    public function provideRepositories(): array
    {
        return [
            [
                $this->mockRepository([
                    'name' => 'foo',
                    'forks' => 12,
                    'watchers' => 1,
                    'stars' => 3,
                ]),
                $this->mockRepository([
                    'name' => 'bar',
                    'forks' => 3,
                    'watchers' => 31,
                    'openedIssues' => 3,
                ]),
            ]
        ];
    }
}