<?php
/**
 * @author        "Michael Collette" <metrol@metrol.net>
 * @package       Metrol/DBConnect
 * @version       1.0
 * @copyright (c) 2016, Michael Collette
 */

namespace Metrol\DBConnect;

/**
 * Interface Schema
 *
 */
interface Schema
{
    const EX_MISSING_CREDENTIALS = 'Missing connection credentials';
    const EX_DATABASE_NAME       = 'Must have a database name in order to connect';

    const DEF_HOST = 'localhost';

    const DSN_DELIM = ';';

    /**
     * Set the database name to talk to
     *
     */
    public function setDatabaseName(string $databaseName): static;

    /**
     * Set the host name to connect to
     *
     */
    public function setHost(string $hostName): static;

    /**
     *
     */
    public function setPort(int $port): static;

    /**
     * Set a generic PDO connection option.  Must use the strings defined in the
     * allowedOptions array in this trait.
     *
     * If the option can not be found in the regular allowed options, the
     * request will automatically be passed to the setDriverOption() to see if
     * it will fit there.
     *
     */
    public function setOption(string $option, string $value): static;

    /**
     * Set the username
     *
     */
    public function setUserName(string $userName): static;

    /**
     * Set the password for the connection
     *
     */
    public function setPassword(string $password): static;

    /**
     * Provide the connection string to be passed into the PDO connection
     *
     */
    public function getDSN(): string;

    /**
     *
     */
    public function getUserName(): string;

    /**
     *
     */
    public function getPassword(): string;

    /**
     *
     */
    public function getOptions(): array;
}
