<?php
/**
 * @author        "Michael Collette" <metrol@metrol.net>
 * @package       Metrol/DBConnect
 * @version       1.0
 * @copyright (c) 2016, Michael Collette
 */

namespace Metrol\DBConnect;

/**
 * Network settings used to tell specify where the database server is.
 *
 */
trait Network
{
    /**
     *
     */
    private string $hostName = '';

    /**
     *
     */
    private int $port;

    /**
     *
     */
    public function setHost(string $hostName): static
    {
        $this->hostName = $hostName;

        return $this;
    }

    /**
     *
     */
    public function getHost(): string
    {
        return $this->hostName;
    }

    /**
     *
     */
    public function setPort(int $port): static
    {
        $this->port = $port;

        return $this;
    }

    /**
     *
     */
    public function getPort(): int
    {
        return $this->port;
    }
}
