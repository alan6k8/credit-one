<?php

declare(strict_types=1);

namespace Alan6k8\CreditOne\Model;

class ModuleFunction
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly int $moduleId,
    ) {
    }
}