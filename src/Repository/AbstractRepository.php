<?php

declare(strict_types=1);

namespace Alan6k8\CreditOne\Repository;

use Alan6k8\CreditOne\Config;
use PDO;
use PDOException;

/**
 * Class assumes that app uses just MySQL. If it would be more complicated than there will have to more base repo classes
 * per each technology.
 */
abstract class AbstractRepository
{
    private const DB_DRIVER ='mysql';

    private PDO $connection;

    abstract protected function getTableName(): string;

    protected function getConnection(): PDO
    {
        if (!isset($this->connection)) {
            $this->connection = $this->connect(Config::buildDsn(self::DB_DRIVER), Config::DB_USER, Config::DB_PASSWORD);
        }

        return $this->connection;
    }

    protected function connect(string $dsn, string $username, string $password): PDO
    {
        try {
            return new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        } catch (PDOException $e) {
            echo 'Failed to connect to database !<br>';
            echo $e->getMessage() . '<br>';
            echo "DSN: {$dsn}<br>";
            die;
        }
    }
}
