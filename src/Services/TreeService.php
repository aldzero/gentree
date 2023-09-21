<?php

declare(strict_types=1);

namespace App\Services;

use App\Schemas\TreeItemSchema;

class TreeService
{
    private const HEADS_KEY = '';

    public function __construct(private readonly array $groupItems)
    {
    }

    public function build(): TreeItemSchema|array
    {
        $parents = $this->groupItems[self::HEADS_KEY];

        return $this->buildChildren($parents);
    }

    private function buildChildren(array $parents): TreeItemSchema|array
    {
        /** @var TreeItemSchema $parent */
        foreach ($parents as $parent) {
            $itemName = $parent->getItemName();
            $relation = $parent->getRelation();

            if ($relation !== '') {
                $this->buildRelation($relation, $parent);
            }

            $children = $this->groupItems[$itemName] ?? null;

            if ($children === null) {
                continue;
            }

            $parent->addChildren($this->buildChildren($children));
        }

        return $parents;
    }

    private function buildRelation(string $relation, TreeItemSchema $parent): void
    {
        $relationChildren = $this->groupItems[$relation] ?? null;

        if ($relationChildren !== null) {
            $parent->addChildren($relationChildren);
        }
    }
}