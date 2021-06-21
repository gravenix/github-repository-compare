<?php

declare(strict_types=1);

namespace App\Api\Types;

use App\Entity\RepositoryEntity;

interface RepositoryApiInterface 
{
    public function getRepository(string $repositoryName): RepositoryEntity;
}