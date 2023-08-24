<?php

declare(strict_types=1);

namespace Alan6k8\CreditOne\Value;

use Alan6k8\CreditOne\Model\ModuleFunction;

class ModuleFunctionCollection extends AbstractCollection
{
    /**
     * @param ModuleFunction[] $itemList
     */
    public function __construct(
        array $itemList,
    ) {
        foreach($itemList as $item) {
            $this->add($item);
        }
    }

    public function add(ModuleFunction $model): void
    {
        $this->items[$model->name] = $model;
    }
}