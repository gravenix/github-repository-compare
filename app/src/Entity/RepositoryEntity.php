<?php

declare(strict_types=1);

namespace App\Entity;

class RepositoryEntity implements Entity
{
    private int $forks;
    
    private int $stars;
    
    private int $watchers;

    private int $openedIssues;

    private string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getForks(): int
    {
        return $this->forks;
    }

    public function setForks(int $forks): void
    {
        $this->forks = $forks;
    }

    public function getStars(): int
    {
        return $this->stars;
    }

    public function setStars(int $stars): void
    {
        $this->stars = $stars;
    }

    public function getWatchers(): int
    {
        return $this->watchers;
    }

    public function setWatchers(int $watchers): void
    {
        $this->watchers = $watchers;
    }

    public function getOpenedIssues(): int
    {
        return $this->openedIssues;
    }

    public function setOpenedIssues(int $openedIssues): void
    {
        $this->openedIssues = $openedIssues;
    }

    public static function fromData(array $data): RepositoryEntity
    {
        $repo = new self();
        $repo->setName($data['name'] ?? '');
        $repo->setForks($data['forks'] ?? 0);
        $repo->setStars($data['stargazers_count'] ?? 0);
        $repo->setWatchers($data['subscribers_count'] ?? 0);
        $repo->setOpenedIssues($data['open_issues_count'] ?? 0);
        //todo closed issues
        // $repo->setClosedPullRequests($data['pull_requests'] ?? 0);

        return $repo;
    }
}