<?php

declare(strict_types=1);

namespace Alan6k8\CreditOne\Value;

use Alan6k8\CreditOne\Model\User;

class UserCollection extends AbstractCollection
{
    /**
     * @param User[] $itemList
     */
    public function __construct(
        array $itemList,
    ) {
        foreach($itemList as $item) {
            $this->add($item);
        }
    }

    public function add(User $model): void
    {
        $this->items[$model->username] = $model;
    }
}