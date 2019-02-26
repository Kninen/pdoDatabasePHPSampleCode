<?php

require('include/dbsettings.php');

class Database
{
    private $host      = DB_HOST;
    private $user      = DB_USER;
    private $pass      = DB_PASS;
    private $dbname    = DB_NAME;

    private $dbh;
    private $error;

    public function __construct()
    {
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=utf8';
        // Set options
        $options = array(
            PDO::ATTR_PERSISTENT    => true,
            PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_EMULATE_PREPARES => false
        );
        // Create a new PDO instance
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        }
        // Catch any errors
        catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    private $stmt;

    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
            case is_int($value):
                $type = PDO::PARAM_INT;
                break;
            case is_bool($value):
                $type = PDO::PARAM_BOOL;
                break;
            case is_null($value):
                $type = PDO::PARAM_NULL;
                break;
            default:
                $type = PDO::PARAM_STR;
        }
        }
        $this->stmt->bindValue($param, $value, $type);
    }
    // The next method we will be look at is the PDOStatement::execute. The execute method executes the prepared statement.
    public function execute()
    {
        return $this->stmt->execute();
    }
    // The Result Set function returns an array of the result set rows. It uses the PDOStatement::fetchAll PDO method.
    public function resultset()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Very similar to the previous method, the Single method simply returns a single record from the database. Again, first we run the execute method, then we return the single result.
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    // The next method simply returns the number of effected rows from the previous delete, update or insert statement.
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
    // The Last Insert Id method returns the last inserted Id as a string
    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }
    // To begin a transaction
    public function beginTransaction()
    {
        return $this->dbh->beginTransaction();
    }
    // To end a transaction and commit your changes
    public function endTransaction()
    {
        return $this->dbh->commit();
    }
    // To cancel a transaction and roll back your changes
    public function cancelTransaction()
    {
        return $this->dbh->rollBack();
    }

    public function debugDumpParams()
    {
        return $this->stmt->debugDumpParams();
    }
}
