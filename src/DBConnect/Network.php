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
     * @var string
     */
    private $hostName;

    /**
     *
     * @var integer
     */
    private $port;

    /**
     * @param string $hostName
     *
     * @return $this
     */
    public function setHost($hostName)
    {
        $this->hostName = $hostName;

        return $this;
    }

    /**
     * 
     * @return string
     */
    public function getHost()
    {
        return $this->hostName;
    }

    /**
     * 
     * @param integer $port
     *
     * @return $this
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     *
     * @return integer
     */
    public function getPort()
    {
        return $this->port;
    }
}
