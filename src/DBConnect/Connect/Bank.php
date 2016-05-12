<?php
/**
 * @author        "Michael Collette" <metrol@metrol.net>
 * @package       Metrol/DBConnect
 * @version       1.0
 * @copyright (c) 2016, Michael Collette
 */

namespace Metrol\DBConnect\Connect;

/**
 * Maintains a list of database connections stored by name
 *
 */
class Bank
{
    const DEFAULT_NAME = 'default';

    /**
     * The list of Connect objects
     *
     * @var \PDO[]
     */
    private static $connectSet = array();

    /**
     * Prevent this class from instantiating
     *
     */
    private function __construct()
    {
        // Nothing to see here
    }

    /**
     * Add a named connection to the stack.
     *
     * @param \PDO $conn
     * @param string  $connectionName
     */
    public static function save(\PDO $conn, $connectionName = self::DEFAULT_NAME)
    {
        self::$connectSet[$connectionName] = $conn;
    }

    /**
     * Provide a named connection from the stack
     *
     * @param string $connectionName
     *
     * @return \PDO|null
     */
    public static function get($connectionName = self::DEFAULT_NAME)
    {
        if ( isset(self::$connectSet[$connectionName]) )
        {
            return self::$connectSet[$connectionName];
        }

        return null;
    }

    /**
     * Disconnect and remove an existing connection
     *
     * @param string $connectionName
     */
    public static function disconnect($connectionName = self::DEFAULT_NAME)
    {
        if ( isset(self::$connectSet[$connectionName]) )
        {
            self::$connectSet[$connectionName] = null;
            unset(self::$connectSet[$connectionName]);
        }
    }
}
