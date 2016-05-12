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
 * Connection information for a MySQL database
 *
 */
class MySQL implements dbc\Schema
{
    use dbc\Credentials;
    use dbc\Network;
    use dbc\Options;

    const DB_TYPE = 'mysql';

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
        $this->allowedDriverOptions = [];

        $this->allowedOptions['localInfile'] = [
            'value' => \PDO::MYSQL_ATTR_LOCAL_INFILE
        ];

        $this->allowedOptions['initCommand'] = [
            'value' => \PDO::MYSQL_ATTR_INIT_COMMAND
        ];

        $this->allowedOptions['readDefaultFile'] = [
            'value' => \PDO::MYSQL_ATTR_READ_DEFAULT_FILE
        ];

        $this->allowedOptions['readDefaultGroup'] = [
            'value' => \PDO::MYSQL_ATTR_READ_DEFAULT_GROUP
        ];

        $this->allowedOptions['maxBufferSize'] = [
            'value' => \PDO::MYSQL_ATTR_MAX_BUFFER_SIZE
        ];

        $this->allowedOptions['directQuery'] = [
            'value' => \PDO::MYSQL_ATTR_DIRECT_QUERY
        ];

        $this->allowedOptions['foundRows'] = [
            'value' => \PDO::MYSQL_ATTR_FOUND_ROWS
        ];

        $this->allowedOptions['ignoreSpace'] = [
            'value' => \PDO::MYSQL_ATTR_IGNORE_SPACE
        ];

        $this->allowedOptions['compress'] = [
            'value' => \PDO::MYSQL_ATTR_COMPRESS
        ];

        $this->allowedOptions['sslCa'] = [
            'value' => \PDO::MYSQL_ATTR_SSL_CA
        ];

        $this->allowedOptions['sslCaPath'] = [
            'value' => \PDO::MYSQL_ATTR_SSL_CAPATH
        ];

        $this->allowedOptions['sslCert'] = [
            'value' => \PDO::MYSQL_ATTR_SSL_CERT
        ];

        $this->allowedOptions['sslCipher'] = [
            'value' => \PDO::MYSQL_ATTR_SSL_CIPHER
        ];

        $this->allowedOptions['sslKey'] = [
            'value' => \PDO::MYSQL_ATTR_SSL_KEY
        ];
    }

    /**
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

        $connectParts = array();

        $connectParts[] = 'dbname='.$this->databaseName;

        if ( $this->hostName !== null )
        {
            $connectParts[] = 'host='.$this->hostName;
        }

        if ( $this->port !== null )
        {
            $connectParts[] = 'port='.$this->port;
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
