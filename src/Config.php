<?php

declare(strict_types=1);

namespace Alan6k8\CreditOne;

class Config
{
    // DB connection - please adopt to your environment
    const DB_HOST = '192.168.119.6';

    const DB_PORT = '13306';

    const DB_SCHEMA = 'credit_one';

    const DB_USER = 'root';

    const DB_PASSWORD = 'root';

    // add more...

    public static function buildDsn(string $dbDriver): string
    {
        return sprintf(
            '%s:host=%s;port=%s;dbname=%s;charset=UTF8',
            strtolower($dbDriver),
            self::DB_HOST,
            self::DB_PORT,
            self::DB_SCHEMA,
        );
    }
}
