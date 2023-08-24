<?php

declare(strict_types=1);

namespace Alan6k8\CreditOne\Model;

class User
{
    public function __construct(
        public readonly int $id,
        public readonly string $username,
        public readonly int $groupId,
    ) {
    }
}