<?php

declare(strict_types=1);

namespace App\Api\GitHub;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class GitHubApiTest extends TestCase
{
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
        
        static::assertEquals($data['forks'], $repository->getForks());
        static::assertEquals($data['stargazers_count'], $repository->getStars());
        static::assertEquals($data['subscribers_count'], $repository->getWatchers());
        static::assertEquals($data['open_issues_count'], $repository->getOpenedIssues());
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