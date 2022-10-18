<?php
/**
 * @author        "Michael Collette" <metrol@metrol.net>
 * @package       Metrol/DBConnect
 * @version       1.0
 * @copyright (c) 2016, Michael Collette
 */

namespace Metrol\DBConnect\Connect;

use PDO;

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
     * @var PDO[]
     */
    private static array $connectSet = [];

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
     */
    public static function save(PDO $conn, string $connectionName = self::DEFAULT_NAME): void
    {
        self::$connectSet[$connectionName] = $conn;
    }

    /**
     * Provide a named connection from the stack
     *
     */
    public static function get(string $connectionName = self::DEFAULT_NAME): ?PDO
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
     */
    public static function disconnect(string $connectionName = self::DEFAULT_NAME): void
    {
        if ( isset(self::$connectSet[$connectionName]) )
        {
            self::$connectSet[$connectionName] = null;
            unset(self::$connectSet[$connectionName]);
        }
    }
}
