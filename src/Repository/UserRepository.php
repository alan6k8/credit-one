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

        /** @var array{id: int, username: string, user_groups_id: int} $row */
        foreach ($statement as $row) {
            $collection->add($this->deserialize($row));
        }

        return $collection;
    }

    public function findOneByUsername(string $username): ?User
    {
        $connection = $this->getConnection();
        $sql = "SELECT * FROM `{$this->getTableName()}` WHERE `username` = '{$username}'";
        $statement = $connection->query($sql);
        if ($statement === false) {
            throw new RuntimeException('Failed to fetch user by username');
        }

        /** @var array{id: int, username: string, user_groups_id: int} $row */
        foreach ($statement as $row) {
            return $this->deserialize($row);
        }

        return null;
    }

    protected function getTableName(): string
    {
        return 'users';
    }

    /**
     * @param array{id: int, username: string, user_groups_id: int} $data
     */
    private function deserialize(array $data): User
    {
        return new User(
            $data['id'],
            $data['username'],
            $data['user_groups_id'],
        );
    }
}