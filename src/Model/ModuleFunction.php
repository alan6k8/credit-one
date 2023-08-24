<?php

declare(strict_types=1);

namespace Alan6k8\CreditOne\Model;

class ModuleFunction
{
    public function __construct(
        public readonly string $name,
        public readonly int $moduleId,
    ) {
    }
}