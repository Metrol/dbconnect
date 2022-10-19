<?php
/**
 * @author        "Michael Collette" <metrol@metrol.net>
 * @package       Metrol/DBConnect
 * @version       1.0
 * @copyright (c) 2022, Michael Collette
 */
namespace Metrol;

use PDO;

interface DBConnect
{
    public function getConnection(): PDO;

    public function bankIt(string $connectionName = 'default'): static;
}
