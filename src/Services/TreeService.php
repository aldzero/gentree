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
        var_dump('конец');
        return $this->buildInDepth($parents);
    }

    private function buildInDepth(array $parents): TreeItemSchema|array
    {
        /** @var TreeItemSchema $parent */
        foreach ($parents as $parent) {

            $itemName = $parent->getItemName();

            $children = $this->groupItems[$itemName] ?? null;


            $relation = $parent->getRelation();

            if ($relation !== '') {

                $relationChildren = $this->groupItems[$relation] ?? null;

                if ($relationChildren !== null) {
                    $parent->addChildren($relationChildren);
                }
            }

            if ($children === null) {
                continue;
            }

            $parent->addChildren($this->buildInDepth($children));
        }

        return $parents;
    }
}