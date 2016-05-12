<?php
/**
 * @author        "Michael Collette" <metrol@metrol.net>
 * @package       Metrol/DBConnect
 * @version       1.0
 * @copyright (c) 2016, Michael Collette
 */

namespace Metrol\DBConnect;
use Metrol\DBConnect\Connect\Bank;

/**
 * Accepts a database connection schema and then readily provides a PDO object
 *
 */
class Connect
{
    /**
     * Connection options to pass into the PDO constructor
     *
     * @var Schema
     */
    private $connectSchema;

    /**
     * Established PDO connection
     *
     * @var \PDO
     */
    private $pdo;

    /**
     * Set the database type and initialize the Connect object
     *
     * @param Schema $connectSchema
     */
    public function __construct(Schema $connectSchema)
    {
        $this->pdo           = null;
        $this->connectSchema = $connectSchema;
    }

    /**
     * Provide the PDO object that was created from the Schema passed in
     *
     * @return \PDO
     *
     * @throws \PDOException Connection errors
     */
    public function getConnection()
    {
        if ( $this->pdo === null )
        {
            $this->pdo = new \PDO($this->connectSchema->getDSN(),
                                  $this->connectSchema->getUserName(),
                                  $this->connectSchema->getPassword(),
                                  $this->connectSchema->getOptions());
        }

        return $this->pdo;
    }

    /**
     * Push the connection created here into the Connect bank.
     *
     * @param string $connectionName
     *
     * @return $this
     */
    public function bankIt($connectionName = 'default')
    {
        Bank::save($this->getConnection(), $connectionName);

        return $this;
    }
}
