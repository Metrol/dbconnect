<?php
/**
 * @author        "Michael Collette" <metrol@metrol.net>
 * @package       Metrol/DBConnect
 * @version       1.0
 * @copyright (c) 2016, Michael Collette
 */

namespace Metrol\DBConnect\Schema;

use Metrol\DBConnect\{Schema, Credentials, Network, Options};
use UnderflowException;

/**
 * Connection information for a PostgreSQL database
 *
 */
class PostgreSQL implements Schema
{
    use Credentials;
    use Network;
    use Options;

    const DB_TYPE = 'pgsql';

    const DEFAULT_PORT = 5432;

    /**
     * PostgreSQL specific connection attributes
     *
     */
    const CONNECT_TIMEOUT  = 'connect_timeout';
    const SSL_MODE         = 'sslmode';
    const KERBEROS_SERVICE = 'krbsrvname';
    const SERVICE_NAME     = 'service';

    /**
     * SSL Modes
     *
     */
    const SSLMODE_DISABLE = 'disable';
    const SSLMODE_ALLOW   = 'allow';
    const SSLMODE_PREFER  = 'prefer';
    const SSLMODE_REQUIRE = 'require';

    /**
     * Database name to connect to
     *
     */
    private string $databaseName = '';

    /**
     *
     */
    public function __construct()
    {
        $this->initAllowedOptions();
        $this->port = self::DEFAULT_PORT;
        $this->hostName = self::DEF_HOST;

    }

    /**
     * Initialize the allowed driver specific connection options
     *
     */
    protected function initAllowedOptions(): void
    {
        $this->allowedDriverOptions =
        [
            self::CONNECT_TIMEOUT  =>
            [
                'value' => self::CONNECT_TIMEOUT
            ],
            self::SSL_MODE =>
            [
                'value' => self::SSL_MODE,
                'options' =>
                [
                    self::SSLMODE_DISABLE,
                    self::SSLMODE_ALLOW,
                    self::SSLMODE_PREFER,
                    self::SSLMODE_REQUIRE
                ]
            ],
            self::KERBEROS_SERVICE =>
            [
                'value' => self::KERBEROS_SERVICE
            ],
            self::SERVICE_NAME =>
            [
                'value' => self::SERVICE_NAME
            ]
        ];
    }

    /**
     * Provide the DSN string that is fed into the PDO Constructor
     *
     * @throws UnderflowException
     */
    public function getDSN(): string
    {
        if ( empty($this->userName) or empty($this->password) )
        {
            $this->password = '';
            throw new UnderflowException(self::EX_MISSING_CREDENTIALS);
        }

        if ( empty($this->databaseName) )
        {
            $this->password = '';
            throw new UnderflowException(self::EX_DATABASE_NAME);
        }

        $connectParts = [];

        $connectParts[] = 'dbname=' . $this->databaseName;

        if ( ! empty($this->hostName) )
        {
            $connectParts[] = 'host=' . $this->hostName;
        }

        if ( ! empty($this->port) )
        {
            $connectParts[] = 'port=' . $this->port;
        }

        if ( ! empty($this->sslMode) )
        {
            $connectParts[] = 'sslmode=' . $this->sslMode;
        }

        if ( ! empty($this->sslCert) )
        {
            $connectParts[] = 'sslcert=' . $this->sslCert;
        }

        if ( ! empty($this->sslKey) )
        {
            $connectParts[] = 'sslkey=' . $this->sslKey;
        }

        if ( ! empty($this->sslRootCert) )
        {
            $connectParts[] = 'sslrootcert=' . $this->sslRootCert;
        }

        // PostgreSQL puts the driver connection options into the connection
        // string rather than passing an array into the option argument in the
        // constructor.
        foreach ( $this->driverOptions as $option => $optionValue )
        {
            $connectParts[] = $option . '=' . $optionValue;
        }

        $connStr = self::DB_TYPE.':';
        $connStr .= implode(self::DSN_DELIM, $connectParts);

        return $connStr;
    }

    /**
     * Set the database name to talk to
     *
     */
    public function setDatabaseName(string $databaseName): static
    {
        $this->databaseName = $databaseName;

        return $this;
    }
}
