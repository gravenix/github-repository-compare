<?php

namespace App\Entity;

class RepositoryReleaseEntity implements Entity
{
    private const DATE_FORMAT = 'yyyy-MM-dd';

    private ?RepositoryEntity $repository;

    private ?\DateTime $relaseDate;

    public function getRepository(): ?RepositoryEntity
    {
        return $this->repository;
    }

    public function setRepository(?RepositoryEntity $repository): void
    {
        $this->repository = $repository;
    }

    public function getReleaseDate(): ?\DateTime
    {
        return $this->relaseDate;
    }

    public function setReleaseDate(?\DateTime $releaseDate): void
    {
        $this->relaseDate = $releaseDate;
    }

    public static function fromData(array $data): RepositoryReleaseEntity
    {
        $release = new self();
        $release->setRepository($data['repository'] ?? null);
        $release->setReleaseDate(isset($data['published_at']) ? new \DateTime($data['published_at']) : null);

        return $release;
    }
}