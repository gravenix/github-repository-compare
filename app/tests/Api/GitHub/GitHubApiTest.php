<?php

declare(strict_types=1);

namespace App\Api\GitHub;

use App\Entity\RepositoryReleaseEntity;
use App\Tests\Helpers\GitHubRepositoryReleaseTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class GitHubApiTest extends TestCase
{
    use GitHubRepositoryReleaseTrait;

    private Client $client;

    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
    }

    /**
     * @dataProvider provideRepositoryData
     */
    public function testGetRepository(array $data): void
    {
        $response = $this->createMock(Response::class);
        $response->method('getBody')
            ->willReturn(\json_encode($data));

        $repo = 'test/test';
        $this->client
            ->expects(static::atLeastOnce())
            ->method('get')
            ->with('repos/' . $repo, [
                'data' => []
            ])
            ->willReturn($response);

        $api = new GitHubApi($this->client);
        $repository = $api->getRepository('test/test');
    }

    /**
     * @dataProvider provideRepositoryReleasesData
     */
    public function testGetReleases(array ...$releases): void
    {
        $repo = 'test/test';
        $expected = \array_map(
            fn(array $data) => RepositoryReleaseEntity::fromData($data),
            $releases
        );

        $response = $this->createMock(Response::class);
        $response->method('getBody')
            ->willReturn(\json_encode($releases));

        $this->client
            ->expects(static::atLeastOnce())
            ->method('get')
            ->with('repos/' . $repo . '/releases', [
                'data' => []
            ])
            ->willReturn($response);

        $api = new GitHubApi($this->client);
        $actual = $api->getRepositoryReleases($repo);
        
        static::assertEquals($expected, $actual);
    }

    public function testGetPullRequests(): void
    {
        $repo = 'test/test';

        $buildPath = static fn(int $page) => 'repos/' . $repo . '/pulls?state=all&page=' . $page;

        $prepareResponse = function (array $data) {
            $response = $this->createMock(Response::class);
            $response->method('getBody')
                ->willReturn(\json_encode(
                    \array_map(static fn(int $id) => ['id' => $id],
                    $data
                )));

            return $response;
        };

        $this->client
            ->expects(static::exactly(2))
            ->method('get')
            ->withConsecutive(
                [$buildPath(1), ['data' => []]], 
                [$buildPath(2), ['data' => []]]
            )->willReturnOnConsecutiveCalls(
                $prepareResponse(\range(1, 30)), 
                $prepareResponse(\range(1, 3))
            );

        $api = new GitHubApi($this->client);
        $collection = $api->getPullRequests($repo);

        static::assertEquals(33, $collection->count());
    }

    public function provideRepositoryReleasesData(): array
    {
        return [
            [
                [],
            ],
            [
                ['published_at' => '2021-06-22'],
            ],
            [
                ['published_at' => '2021-06-12'],
                ['published_at' => '2021-06-02'],
                ['published_at' => '2021-01-22'],
            ]
        ];
    }

    public function provideRepositoryData(): array
    {
        return [
            [
                [
                    'forks' => 12,
                    'stargazers_count' => 8,
                    'subscribers_count' => 3,
                    'open_issues_count' => 2,
                ]
            ],
            [
                [
                    'forks' => 1,
                ]
            ]
        ];
    }
}