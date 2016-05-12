#!/usr/bin/php -q
<?php
namespace Metrol\DBConnect;

define('BASE_PATH', realpath(dirname(__FILE__).'/..'));

include BASE_PATH.'/vendor/autoload.php';

$schema = (new Schema\PostgreSQL)
    ->setHost('localhost')
    ->setPort(5432)
    ->setDatabaseName('testdb')
    ->setUserName('testuser')
    ->setPassword('testuserpass');

$schema->setOption('errorMode', 'exception');

var_dump($schema->getOptions());
var_dump($schema->getDSN());

$connect = new Connect($schema);
$pdo = $connect->getConnection();

echo $pdo->getAttribute(\PDO::ATTR_CONNECTION_STATUS).PHP_EOL;
echo $pdo->getAttribute(\PDO::ATTR_DRIVER_NAME).PHP_EOL;
echo $pdo->getAttribute(\PDO::ATTR_SERVER_INFO).PHP_EOL;
echo $pdo->getAttribute(\PDO::ATTR_SERVER_VERSION).PHP_EOL;


