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

    // TODO tests
}