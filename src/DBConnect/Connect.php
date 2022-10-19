<?php
/**
 * @author        "Michael Collette" <metrol@metrol.net>
 * @package       Metrol/DBConnect
 * @version       1.0
 * @copyright (c) 2016, Michael Collette
 */

namespace Metrol\DBConnect;

use Metrol\DBConnect;
use Metrol\DBConnect\Connect\Bank;
use PDO;
use PDOException;

/**
 * Accepts a database connection schema and then readily provides a PDO object
 *
 */
class Connect implements DBConnect
{
    /**
     * Connection options to pass into the PDO constructor
     *
     */
    private Schema $connectSchema;

    /**
     * Established PDO connection
     *
     */
    private PDO $pdo;

    /**
     * Set the database type and initialize
     *
     */
    public function __construct(Schema $connectSchema)
    {
        $this->connectSchema = $connectSchema;
    }

    /**
     * Provide the PDO object that was created from the Schema passed in
     *
     * @throws PDOException Connection errors
     */
    public function getConnection(): PDO
    {
        if ( ! isset($this->pdo) )
        {
            $this->pdo = new PDO($this->connectSchema->getDSN(),
                                 $this->connectSchema->getUserName(),
                                 $this->connectSchema->getPassword(),
                                 $this->connectSchema->getOptions());
        }

        return $this->pdo;
    }

    /**
     * Push the connection created here into the bank
     *
     */
    public function bankIt(string $connectionName = 'default'): static
    {
        Bank::save($this->getConnection(), $connectionName);

        return $this;
    }
}
