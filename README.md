# Metrol\DBConnect
## A PHP library for connecting to databases via PDO

The goal here is to somewhat simplify connecting to a database with PDO either by manually creating Schema objects with connection information or to load that information using a configuration file.

Each connection can be added to a Connection Bank that allows easy access to an established connection.  Using the INI loader, every named connection is automatically stored in this back, ready to be used.  Initializing the loader looks like...

```php
(new \Metrol\DBConnect\Load\INI('database.ini'))->run();
```

You can find an example INI configuration file in the etc directory of this repository.

Once loaded, any connections established will be readily accessible with...

```php
$pdo = \Metrol\DBConnect\Connect\Bank::get();
```

If you've got multiple connections established, you would pull them in by name.

```php
$postgrePdo = \Metrol\DBConnect\Connect\Bank::get('pgconnect');
$mysqlPdo = \Metrol\DBConnect\Connect\Bank::get('mysqlconnect');
```

Of you can call any of this manually without having to get a configuration file involved.

```php
$schema = (new Schema\PostgreSQL)
    ->setHost('localhost')
    ->setPort(5432)
    ->setDatabaseName('testdb')
    ->setUserName('testuser')
    ->setPassword('testuserpass');

$schema->setOption('errorMode', 'exception');

$pdo = (new \Metrol\DBConnect\Connect($schema))->getConnection();
```

Options for both PDO and driver specific options are given string equivalents instead of using the PDO constants.  This allows for values to be put into a configuration file.  The nice part about this is that if you have multiple connections setup in your configuration, each one can be provided it's own set of connection options.  Just as importantly, you can have multiple database types that each have their own set of options.

Since much of this is abstracted out, you don't need to worry about how an option needs to be put in place.  Does it go into the options array, or the DSN?  Where do the username password go for that driver?  This library takes care of those details, smoothing out the process.

## Status
At the moment this has been tested against PostgreSQL most heavily.  Some testing has been applied to MySQL, but more is needed.  I'm hoping to finish up SQLite support in the near future, along with proper unit tests for each.
