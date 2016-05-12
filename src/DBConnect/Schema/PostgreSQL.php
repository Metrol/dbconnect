<?php
/**
 * @author        "Michael Collette" <metrol@metrol.net>
 * @package       Metrol/DBConnect
 * @version       1.0
 * @copyright (c) 2016, Michael Collette
 */

namespace Metrol\DBConnect\Schema;
use Metrol\DBConnect as dbc;

/**
 * Connection information for a PostgreSQL database
 *
 */
class PostgreSQL implements dbc\Schema
{
    use dbc\Credentials;
    use dbc\Network;
    use dbc\Options;

    const DB_TYPE = 'pgsql';

    /**
     * PostgreSQL specific connection attributes
     *
     * @const
     */
    const CONNECT_TIMEOUT  = 'connect_timeout';
    const SSL_MODE         = 'sslmode';
    const KERBEROS_SERVICE = 'krbsrvname';
    const SERVICE_NAME     = 'service';

    /**
     * SSL Modes
     *
     * @const
     */
    const SSLMODE_DISABLE = 'disable';
    const SSLMODE_ALLOW   = 'allow';
    const SSLMODE_PREFER  = 'prefer';
    const SSLMODE_REQUIRE = 'require';

    /**
     * Database name to connect to
     *
     * @var string
     */
    private $databaseName;

    /**
     *
     */
    public function __construct()
    {
        $this->initAllowedOptions();
    }

    /**
     * Initialize the allowed driver specific connection options
     *
     */
    protected function initAllowedOptions()
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
     * @return string
     *
     * @throws \UnderflowException
     */
    public function getDSN()
    {
        if ( $this->userName === null or $this->password === null )
        {
            $this->password = null;
            throw new \UnderflowException(self::EX_MISSING_CREDENTIALS);
        }

        if ( $this->databaseName === null )
        {
            $this->password = null;
            throw new \UnderflowException(self::EX_DATABASE_NAME);
        }

        $connectParts = [];

        $connectParts[] = 'dbname='.$this->databaseName;

        if ( $this->hostName !== null )
        {
            $connectParts[] = 'host='.$this->hostName;
        }

        if ( $this->port !== null )
        {
            $connectParts[] = 'port='.$this->port;
        }

        // PostgreSQL puts the driver connection options into the connection
        // string rather than passing an array into the options argument in the
        // constructor.
        foreach ( $this->driverOptions as $option => $optionValue )
        {
            $connectParts[] = $option .'='. $optionValue;
        }

        $connStr = self::DB_TYPE.':';
        $connStr .= implode(self::DSN_DELIM, $connectParts);

        return $connStr;
    }

    /**
     * Set the database name to talk to
     *
     * @param string $databaseName
     *
     * @return $this
     */
    public function setDatabaseName($databaseName)
    {
        $this->databaseName = $databaseName;

        return $this;
    }
}
