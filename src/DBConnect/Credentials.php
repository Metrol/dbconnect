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
     * The username credential for the connection
     *
     */
    private string $userName = '';

    /**
     * The password credential for the connection
     *
     */
    private string $password = '';

    /**
     * Set the username
     *
     */
    public function setUserName(string $userName): static
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get the username credential for the connection
     *
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * Set the password for the connection
     *
     */
    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Provide the password for the connection
     *
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
