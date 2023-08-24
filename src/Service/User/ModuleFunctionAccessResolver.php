<?php

declare(strict_types=1);

namespace Alan6k8\CreditOne\Service\User;

use Alan6k8\CreditOne\Repository\UserAccessRepository;

class ModuleFunctionAccessResolver
{
    public function __construct(
        private readonly UserAccessRepository $userAccessRepository,
    ) {
    }

    public function resolve(string $username, string $functionName): bool
    {
        return mt_rand(1, 100) % 2 === 0;
    }
}