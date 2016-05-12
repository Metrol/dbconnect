<?php
/**
 * @author        "Michael Collette" <metrol@metrol.net>
 * @package       Metrol/DBConnect
 * @version       1.0
 * @copyright (c) 2016, Michael Collette
 */

namespace Metrol\DBConnect;

/**
 * Setters and getters for connection credentials that we be needed for
 * authenticating to the database.
 *
 * @package Metrol\DBConnect
 */
trait Credentials
{
    /**
     * The user name credential for the connection
     *
     * @var string
     */
    private $userName;

    /**
     * The password credential for the conenction
     *
     * @var string
     */
    private $password;

    /**
     * Set the user name
     *
     * @param string $userName
     *
     * @return $this
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get the user name credential for the connection
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set the password for the connection
     *
     * @param mixed $password
     *
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Provide the password for the connection
     *
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }
}
