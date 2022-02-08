<?php
/**
 * @author        "Michael Collette" <metrol@metrol.net>
 * @package       Metrol/DBConnect
 * @version       1.0
 * @copyright (c) 2016, Michael Collette
 */

namespace Metrol\DBConnect\Schema;

use Metrol\DBConnect\Schema;
use InvalidArgumentException;

/**
 * Provides the correct connection schema base on the DB type
 *
 */
class Factory
{
    /**
     *
     */
    private function __construct()
    {
        // Standing at the corner with nothing much to do
    }

    /**
     * Provide the schema for the specified database type
     *
     * @throws InvalidArgumentException
     */
    public static function getSchema(string $dbType): Schema
    {
        return match (strtolower($dbType))
        {
            PostgreSQL::DB_TYPE => new PostgreSQL,
            MySQL::DB_TYPE => new MySQL,
            default => throw new InvalidArgumentException('Unknown database type requested'),
        };
    }
}
