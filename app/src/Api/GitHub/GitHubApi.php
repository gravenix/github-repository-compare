<?php

declare(strict_types=1);

namespace App\Api\GitHub;

use App\Api\AbstractApi;
use App\Api\Types\RepositoryApiInterface;
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
}