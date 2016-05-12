<?php
/**
 * @author        "Michael Collette" <metrol@metrol.net>
 * @package       Metrol/DBConnect
 * @version       1.0
 * @copyright (c) 2016, Michael Collette
 */

namespace Metrol\DBConnect\Schema;
use Metrol\DBConnect as dbc;

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
     * @param string $dbType
     *
     * @return dbc\Schema
     *
     * @throws \InvalidArgumentException
     */
    public static function getSchema($dbType)
    {
        switch ( strtolower($dbType) )
        {
            case PostgreSQL::DB_TYPE:
                $schema = new PostgreSQL;
                break;

            case MySQL::DB_TYPE:
                $schema = new MySQL;
                break;

            default:
                throw new \InvalidArgumentException('Unknown database type requested');
        }

        return $schema;
    }
}
