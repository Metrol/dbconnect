#!/usr/bin/php -q
<?php
namespace Metrol\DBConnect;

use Metrol\DBConnect\Connect\Bank;
use PDO;

define('BASE_PATH', realpath(dirname(__FILE__).'/..'));
include BASE_PATH.'/vendor/autoload.php';

(new Load\INI(BASE_PATH.'/etc/postgresql_test.ini'))->run();

$pdo = Bank::get();
echo $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS).PHP_EOL;
echo $pdo->getAttribute(PDO::ATTR_DRIVER_NAME).PHP_EOL;
echo $pdo->getAttribute(PDO::ATTR_SERVER_INFO).PHP_EOL;
echo $pdo->getAttribute(PDO::ATTR_SERVER_VERSION).PHP_EOL;
