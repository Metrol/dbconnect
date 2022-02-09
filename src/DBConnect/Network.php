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

    private string $sslMode = '';
    private string $sslKey  = '';
    private string $sslCert = '';
    private string $sslRootCert = '';

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
    public function setSslMode(string $sslMode): static
    {
        $this->sslMode = $sslMode;

        return $this;
    }

    /**
     */
    public function setSslKey(string $sslKey): static
    {
        $this->sslKey = $sslKey;

        return $this;
    }

    /**
     */
    public function setSslCert(string $sslCert): static
    {
        $this->sslCert = $sslCert;

        return $this;
    }


    /**
     */
    public function setSslRootCert(string $sslRootCert): static
    {
        $this->sslRootCert = $sslRootCert;

        return $this;
    }
}
