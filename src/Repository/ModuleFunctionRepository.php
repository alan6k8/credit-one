<?php

declare(strict_types=1);

namespace Alan6k8\CreditOne\Repository;

use Alan6k8\CreditOne\Model\ModuleFunction;
use Alan6k8\CreditOne\Value\ModuleFunctionCollection;
use RuntimeException;

class ModuleFunctionRepository extends AbstractRepository
{
    /**
     * @internal this is just a very simple implementation that will encounter OOM issues once there is enough records
     */
    public function findAll(): ModuleFunctionCollection
    {
        $collection = new ModuleFunctionCollection([]);
        $connection = $this->getConnection();
        $statement = $connection->query("SELECT * FROM `{$this->getTableName()}`");
        if ($statement === false) {
            throw new RuntimeException('Failed to fetch module functions');
        }

        /** @var array{id: int, name: string, modules_id: int} $row */
        foreach ($statement as $row) {
            $collection->add($this->deserialize($row));
        }

        return $collection;
    }

    public function findOneByName(string $name): ?ModuleFunction
    {
        $connection = $this->getConnection();
        $sql = "SELECT * FROM `{$this->getTableName()}` WHERE `name` = '{$name}'";
        $statement = $connection->query($sql);
        if ($statement === false) {
            throw new RuntimeException('Failed to fetch module function by name');
        }

        /** @var array{id: int, name: string, modules_id: int} $row */
        foreach ($statement as $row) {
            return $this->deserialize($row);
        }

        return null;
    }

    protected function getTableName(): string
    {
        return 'module_functions';
    }

    /**
     * @param array{id: int, name: string, modules_id: int} $data
     */
    private function deserialize(array $data): ModuleFunction
    {
        return new ModuleFunction(
            $data['id'],
            $data['name'],
            $data['modules_id'],
        );
    }
}