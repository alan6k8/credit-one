<?php

declare(strict_types=1);

namespace Alan6k8\CreditOne\Model;

class ModuleFunctionAccessRight
{
    public function __construct(
        public readonly int $id,
        public readonly ?int $userId,
        public readonly ?int $userGroupId,
        public readonly ?int $moduleId,
        public readonly ?int $moduleFunctionId,
    ) {
    }
}