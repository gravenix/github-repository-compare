<?php

declare(strict_types=1);

namespace App\Comparer;

interface ComparerInterface
{
    public function toJson(array $entities): array;
}