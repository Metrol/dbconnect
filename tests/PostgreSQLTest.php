<?php
/**
 * @author        Michael Collette <mcollette@meetingevolution.net>
 * @version       1.0
 * @package       Sourcing
 * @copyright (c) 2022, Meeting Evolution
 */

namespace Metrol\Tests;

use PHPUnit\Framework\TestCase;
use Metrol\DBConnect\{Schema, Connect};
use PDO;

/**
 * Describe purpose of PostgreSQLTest
 *
 */
class PostgreSQLTest extends TestCase
{
    const HOST = 'localhost';
    const PORT = Schema\PostgreSQL::DEFAULT_PORT;
    const DBNAME = 'MetrolTest';
    const USER   = 'metrol';
    const PASS   = 'metrolpass';


    public function testDsnString(): void
    {
        $schema = Schema\Factory::getSchema(Schema\PostgreSQL::DB_TYPE);

        $this->assertEquals(Schema\PostgreSQL::DB_TYPE, $schema::DB_TYPE);

        $this->assertInstanceOf('\\Metrol\\DBConnect\\Schema\\PostgreSQL',
                                $schema);

        $schema->setHost(self::HOST)
               ->setPort(self::PORT)
               ->setUserName(self::USER)
               ->setPassword(self::PASS)
               ->setDatabaseName(self::DBNAME);

        $this->assertEquals('pgsql:dbname=MetrolTest;host=localhost;port=5432',
                            $schema->getDSN());
    }

    public function testPdoOptions(): void
    {
        $schema = Schema\Factory::getSchema(Schema\PostgreSQL::DB_TYPE);

        $schema->setOption('columnCase', 'natural')
            ->setOption('fetchMode', 'object')
            ->setOption('errorMode', 'exception')
            ->setOption('nullConversion', 'natural')
            ->setOption('stringify', 'false')
            ->setOption('emulatePrepare', 'false');

        $options = $schema->getOptions();

        $this->assertNotEmpty($options);
        $this->assertCount(6, $options);

        // Make sure all the options equate to real PDO options
        $this->assertArrayHasKey(PDO::ATTR_CASE, $options);
        $this->assertArrayHasKey(PDO::ATTR_DEFAULT_FETCH_MODE, $options);
        $this->assertArrayHasKey(PDO::ATTR_ERRMODE, $options);
        $this->assertArrayHasKey(PDO::ATTR_ORACLE_NULLS, $options);
        $this->assertArrayHasKey(PDO::ATTR_STRINGIFY_FETCHES, $options);
        $this->assertArrayHasKey(PDO::ATTR_EMULATE_PREPARES, $options);

        $this->assertEquals(PDO::CASE_NATURAL, $options[PDO::ATTR_CASE]);
        $this->assertEquals(PDO::FETCH_OBJ, $options[PDO::ATTR_DEFAULT_FETCH_MODE]);
        $this->assertEquals(PDO::ERRMODE_EXCEPTION, $options[PDO::ATTR_ERRMODE]);
        $this->assertEquals(PDO::NULL_NATURAL, $options[PDO::ATTR_ORACLE_NULLS]);
        $this->assertFalse($options[PDO::ATTR_STRINGIFY_FETCHES]);
        $this->assertFalse($options[PDO::ATTR_EMULATE_PREPARES]);
    }

    public function testSslDsn(): void
    {
        $schema = Schema\Factory::getSchema(Schema\PostgreSQL::DB_TYPE);

        $schema->setUserName(self::USER)
            ->setPassword(self::PASS)
            ->setDatabaseName(self::DBNAME);

        $schema->setSslMode('required')
            ->setSslKey('key.pem')
            ->setSslCert('cert.pem')
            ->setSslRootCert('root.pem');

        $expected = 'pgsql:dbname=MetrolTest;host=localhost;port=5432;'
            .'sslmode=required;sslcert=cert.pem;sslkey=key.pem;sslrootcert=root.pem';

        $this->assertEquals($expected, $schema->getDSN());
    }

    public function testConnection(): void
    {
        $schema = Schema\Factory::getSchema(Schema\PostgreSQL::DB_TYPE);

        $schema->setUserName(self::USER)
               ->setPassword(self::PASS)
               ->setDatabaseName(self::DBNAME);

        $schema->setOption('columnCase', 'natural')
               ->setOption('errorMode', 'exception')
               ->setOption('nullConversion', 'natural')
               ->setOption('stringify', 'false')
               ->setOption('emulatePrepare', 'false')
               ->setOption('fetchMode', 'object');

        $conn = new Connect($schema);
        $dbc = $conn->getConnection();

        $this->assertNotFalse($dbc);
        $this->assertInstanceOf('\\PDO', $dbc);

        $this->assertEquals(PDO::ERRMODE_EXCEPTION, $dbc->getAttribute(PDO::ATTR_ERRMODE));
        $this->assertEquals('Connection OK; waiting to send.', $dbc->getAttribute(PDO::ATTR_CONNECTION_STATUS));

        $serverInfo = $dbc->getAttribute(PDO::ATTR_SERVER_INFO);
        $this->assertStringStartsWith('PID:', $serverInfo);
    }
}
