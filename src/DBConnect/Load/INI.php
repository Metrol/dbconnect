<?php
/**
 * @author        "Michael Collette" <metrol@metrol.net>
 * @package       Metrol/DBConnect
 * @version       1.0
 * @copyright (c) 2016, Michael Collette
 */

namespace Metrol\DBConnect\Load;
use Metrol\DBConnect\Schema;
use Metrol\DBConnect\Connect;

/**
 * Processes an INI file and creates connections for each specified
 * configuration
 *
 */
class INI
{
    /**
     * File name of the INI file with complete path
     *
     * @var string
     */
    protected $confFile;

    /**
     * Defines the keys that should not be used as an option.  They are for any
     * connection.  For example, the host or database name.
     *
     * @var string[]
     */
    protected $connectKeys;

    /**
     * Store the file name and prep this object
     *
     * @param string $configurationFilename
     */
    public function __construct($configurationFilename)
    {
        $this->confFile = $configurationFilename;
        $this->initConnectKeys();
    }

    /**
     * Process the configuration file and bank the connections
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function run()
    {
        if ( ! file_exists($this->confFile) )
        {
            throw new \InvalidArgumentException('Specified configuration not found');
        }

        $parsed = parse_ini_file($this->confFile, true);

        foreach ( $parsed as $connectionName => $attributes )
        {
            $schema = $this->getSchema($attributes);
            $this->setConnectionValues($schema, $attributes);
            $this->setOptions($schema, $attributes);

            (new Connect($schema))->bankIt($connectionName);

            echo $schema->getDSN().PHP_EOL;
            var_dump($schema->getOptions());
        }
    }

    /**
     * Fetch the appropriate schema from the Schema Factory
     *
     * @param array $attributes
     *
     * @return Schema
     *
     * @throws \InvalidArgumentException
     */
    protected function getSchema(array $attributes)
    {
        if ( isset($attributes['dbtype']) )
        {
            $schema = Schema\Factory::getSchema($attributes['dbtype']);
        }
        else
        {
            throw new \InvalidArgumentException('Unknown database type');
        }

        return $schema;
    }

    /**
     * Fills in connection options for the specified schema from the attributes
     * that came through
     *
     * @param Schema $schema
     * @param array  $attributes
     */
    protected function setConnectionValues(Schema $schema, array $attributes)
    {
        if ( isset($attributes['host']) )
        {
            $schema->setHost($attributes['host']);
        }

        if ( isset($attributes['port']) )
        {
            $schema->setPort($attributes['port']);
        }

        if ( isset($attributes['dbname']) )
        {
            $schema->setDatabaseName($attributes['dbname']);
        }

        if ( isset($attributes['user']) )
        {
            $schema->setUserName($attributes['user']);
        }

        if ( isset($attributes['password']) )
        {
            $schema->setPassword($attributes['password']);
        }
    }

    /**
     * Everything that isn't a connection key will attempt to be stored as a
     * connection option.
     *
     * @param Schema $schema
     * @param array  $attributes
     */
    protected function setOptions(Schema $schema, array $attributes)
    {
        foreach ( $attributes as $option => $value )
        {
            if ( in_array('option', $this->connectKeys) )
            {
                continue;
            }

            $schema->setOption($option, $value);
        }
    }

    /**
     * Fill in the array of connection keys that should not be interpereted as
     * a connection option.
     *
     */
    private function initConnectKeys()
    {
        $this->connectKeys = [
            'dbtype',
            'host',
            'port',
            'dbname',
            'user',
            'password'
        ];
    }
}
