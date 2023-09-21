<?php

declare(strict_types=1);

namespace App\Schemas;

use JsonSerializable;

class TreeItemSchema implements JsonSerializable
{
    private ?array $children = [];

    public function __construct(
        private string $itemName,
        private string $parent,
        private string $relation,
    ){

    }

    public function getItemName(): string
    {
        return $this->itemName;
    }

    public function setItemName(string $itemName): void
    {
        $this->itemName = $itemName;
    }

    public function getParent(): string
    {
        return $this->parent;
    }

    public function setParent(string $parent): void
    {
        $this->parent = $parent;
    }

    public function getRelation(): string
    {
        return $this->relation;
    }

    public function setRelation(string $relation): void
    {
        $this->relation = $relation;
    }

    public function getChildren(): ?array
    {
        return $this->children;
    }

    public function addChildren(TreeItemSchema|array $children): void
    {
        $this->children = array_merge($this->children, $children);
    }

    public function jsonSerialize(): array
    {
        return [
            'itemName' => $this->itemName,
            'parent' => $this->parent,
            'children' => $this->children
        ];
    }
}