<?php

declare(strict_types=1);

namespace Alan6k8\CreditOne\Repository;

use Alan6k8\CreditOne\Model\ModuleFunctionAccessRight;
use Generator;
use RuntimeException;
use UnexpectedValueException;

class ModuleFunctionAccessRightRepository extends AbstractRepository
{
    /**
     * @return Generator<int, ModuleFunctionAccessRight, ModuleFunctionAccessRight, void>
     */
    public function findByUserIdOrUserGroupId(int $userId, int $userGroupsId): Generator
    {
        // Select access rights for user or its group. As access can be granted via module (not only directly to its
        // functions), join is used to resolve module id to its functions.
        $sql = 'SELECT ac.*, mf.id AS joined_modules_function_id '
            . 'FROM module_function_access_rights ac '
            . 'LEFT JOIN module_functions mf on mf.modules_id = ac.modules_id '
            . 'WHERE ac.users_id = ? OR ac.user_groups_id = ? ';

        $connection = $this->getConnection();
        $statement = $connection->prepare($sql);
        if ($statement === false) {
            throw new RuntimeException('Failed to prepare fetch of module functions access rights');
        }
        if($statement->execute([$userId, $userGroupsId]) === false) {
            throw new RuntimeException('Failed to execute fetch of module functions access rights');
        }

        /** @var array{
         *  id: int,
         *  users_id: int|null,
         *  user_groups_id: int|null,
         *  modules_id: int|null,
         *  modules_function_id: int|null,
         *  joined_modules_function_id?: int|null
         * } $row */
        foreach ($statement->fetchAll() as $row) {
            // optimization, we just the the first positive answer thus no need to deserialize all records
            $model = $this->deserialize($row);
            if ($model->moduleFunctionId === null) {
                // if db records are correct, most likely an implementation error (e.g. SQL as this should be always set)
                throw new UnexpectedValueException(
                    'Failed to deserialize ModuleFunctionAccessRight due to missing its function id'
                );
            }

            yield $model;
        }
    }

    protected function getTableName(): string
    {
        return 'module_function_access_rights';
    }

    /**
     * @param array{
     *  id: int,
     *  users_id: int|null,
     *  user_groups_id: int|null,
     *  modules_id: int|null,
     *  modules_function_id: int|null,
     *  joined_modules_function_id?: int|null,
     * } $data
     */
    private function deserialize(array $data): ModuleFunctionAccessRight
    {
        return new ModuleFunctionAccessRight(
            $data['id'],
            $data['users_id'],
            $data['user_groups_id'],
            $data['modules_id'],
            // a trick, joined function id represents id resolved based on modules_id
            $data['modules_function_id'] ?? $data['joined_modules_function_id'] ?? null,
        );
    }
}
