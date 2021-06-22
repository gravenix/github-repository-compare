<?php

declare(strict_types=1);

namespace App\Api\GitHub;

use App\Api\AbstractApi;
use App\Api\Types\RepositoryApiInterface;
use App\Entity\PullRequest;
use App\Entity\PullRequestCollection;
use App\Entity\RepositoryEntity;
use App\Entity\RepositoryReleaseEntity;
use GuzzleHttp\Client;

class GitHubApi extends AbstractApi implements RepositoryApiInterface
{
    private const REPO_PATH = 'repos/';

    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    public function getRepository(string $repositoryName): RepositoryEntity
    {
        $response = $this->get(self::REPO_PATH . $repositoryName);
        $data = \json_decode((string) $response->getBody(), true);

        return RepositoryEntity::fromData($data);
    }

    /**
     * @return array<RepositoryRelaseEntity>
     */
    public function getRepositoryReleases(string $repositoryName): array
    {
        $response = $this->get(self::REPO_PATH . $repositoryName . '/releases');
        $data = \json_decode((string) $response->getBody(), true);

        return \array_map(
            static fn(array $releaseData) => RepositoryReleaseEntity::fromData($releaseData),
            $data
        );
    }

    public function getPullRequests(string $repositoryName): PullRequestCollection
    {
        $path = static fn(int $page) => self::REPO_PATH . $repositoryName . '/pulls?state=all&page=' . $page;
        $result = [];
        $page = 1;
        // I know it's bad, but I couldn't find better way to get total pull requests
        // there is no 'total' in this response
        do {
            $response = \array_map(
                static fn(array $data) => PullRequest::fromData($data),
                \json_decode((string) $this->get($path($page++))->getBody(), true)
            );
            $result = \array_merge($result, $response);
        } while (\count($response) === 30);

        return new PullRequestCollection($result);
    }
}