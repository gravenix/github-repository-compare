<?php

declare(strict_types=1);

namespace App\Struct;

abstract class Collection
{
    private array $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function count()
    {
        return \count($this->items);
    }
}