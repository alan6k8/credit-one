<?php

declare(strict_types=1);

namespace Alan6k8\CreditOne\Service\User;

use Alan6k8\CreditOne\Repository\ModuleFunctionAccessRightRepository;
use Alan6k8\CreditOne\Repository\ModuleFunctionRepository;
use Alan6k8\CreditOne\Repository\UserRepository;
use InvalidArgumentException;

class ModuleFunctionAccessResolver
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly ModuleFunctionRepository $moduleFunctionRepository,
        private readonly ModuleFunctionAccessRightRepository $userAccessRepository,
    ) {
    }

    public function resolve(string $username, string $functionName): bool
    {
        $user = $this->userRepository->findOneByUsername($username);
        if ($user === null) {
            throw new InvalidArgumentException('No such user');
        }

        $function = $this->moduleFunctionRepository->findOneByName($functionName);
        if ($function === null) {
            throw new InvalidArgumentException('No such function');
        }

        foreach ($this->userAccessRepository->findByUserIdOrUserGroupId($user->id, $user->groupId) as $userAccess) {
            if ($userAccess->moduleFunctionId === $function->id) {
                return true;
            }
        }

        // no access as default
        return false;
    }
}