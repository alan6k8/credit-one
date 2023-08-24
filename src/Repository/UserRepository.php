<?php

declare(strict_types=1);

namespace Alan6k8\CreditOne\Repository;

use Alan6k8\CreditOne\Model\User;
use Alan6k8\CreditOne\Value\UserCollection;
use RuntimeException;

class UserRepository extends AbstractRepository
{
    /**
     * @internal this is just a very simple implementation that will encounter OOM issues once there is enough records
     */
    public function findAll(): UserCollection
    {
        $collection = new UserCollection([]);
        $connection = $this->getConnection();
        $sql = "SELECT * FROM `{$this->getTableName()}`";
        $statement = $connection->query($sql);
        if ($statement === false) {
            throw new RuntimeException('Failed to fetch users');
        }

        /** @var array{username: string, user_groups_id: int} $row */
        foreach ($statement as $row) {
            $collection->add($this->deserialize($row));
        }

        return $collection;
    }

    protected function getTableName(): string
    {
        return 'users';
    }

    /**
     * @param array{username: string, user_groups_id: int} $data
     */
    private function deserialize(array $data): User
    {
        return new User(
            $data['username'],
            $data['user_groups_id'],
        );
    }
}