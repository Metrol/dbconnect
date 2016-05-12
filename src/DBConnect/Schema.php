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

    const DSN_DELIM = ';';

    /**
     * Set the database name to talk to
     *
     * @param string $databaseName
     *
     * @return $this
     */
    public function setDatabaseName($databaseName);

    /**
     * @param string $hostName
     *
     * @return $this
     */
    public function setHost($hostName);

    /**
     *
     * @param integer $port
     *
     * @return $this
     */
    public function setPort($port);

    /**
     * Set a generic PDO conection option.  Must use the strings defined in the
     * allowedOptions array in this trait.
     *
     * If the option can not be found in the regular allowed options, the
     * request will automatically be passed to the setDriverOption() to see if
     * it will fit there.
     *
     * @param string $option Which option to be set
     * @param string $value  What value to assign to that option
     *
     * @return $this
     */
    public function setOption($option, $value);

    /**
     * Set the user name
     *
     * @param string $userName
     *
     * @return $this
     */
    public function setUserName($userName);

    /**
     * Set the password for the connection
     *
     * @param mixed $password
     *
     * @return $this
     */
    public function setPassword($password);

    /**
     *
     * @return string
     */
    public function getDSN();

    /**
     *
     * @return string
     */
    public function getUserName();

    /**
     *
     * @return string
     */
    public function getPassword();

    /**
     *
     * @return array
     */
    public function getOptions();
}
