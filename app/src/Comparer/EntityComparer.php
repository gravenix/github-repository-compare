<?php

declare(strict_types=1);

namespace App\Comparer;

use App\Entity\Entity;
use App\Comparer\ComparerInterface;

abstract class EntityComparer implements ComparerInterface
{
    protected array $fields = [];

    public function toJson(array $entities): array
    {
        $result = [];
        foreach ($this->fields as $field => $method) {
            $result[$field] = $this->getFieldForEntities($entities, $method);
        }

        return $result;
    }

    private function getField(Entity $entity, string $method): ?string
    {
        if (!\method_exists($entity, $method)) {
            return null;
        }

        return (string) $entity->$method();
    }

    private function getFieldForEntities(array $entities, string $method): array
    {
        $result = [];
        foreach ($entities as $entity) {
            $result[$entity->getName()] = $this->getField($entity, $method);
        }

        return $result;
    }
}