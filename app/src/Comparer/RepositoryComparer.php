<?php

declare(strict_types=1);

namespace App\Comparer;

class RepositoryComparer extends EntityComparer
{
    protected array $fields = [
        'stars' => 'getStars',
        'watchers' => 'getWatchers',
        'forks' => 'getForks',
        'openedIssues' => 'getOpenedIssues',
    ];

    public function toJson(array $entities): array
    {
        $result = parent::toJson($entities);
        foreach ($entities as $entity) {
            $latestRelease = $entity->getLatestRelease();
            $pullRequests = $entity->getPullRequests();

            $result['closedIssues'][$entity->getName()] = (string) ($pullRequests ? $pullRequests->count() - $entity->getOpenedIssues() : null);
            $result['latestRelease'][$entity->getName()] = $latestRelease ? $latestRelease->getReleaseDate() : null;
        }

        return $result;
    }
}