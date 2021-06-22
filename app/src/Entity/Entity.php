<?php

declare(strict_types=1);

namespace App\Entity;

interface Entity
{
    public static function fromData(array $data): Entity;
}