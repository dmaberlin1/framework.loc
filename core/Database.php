<?php

namespace PHPFramework;

class Database
{
    public \PDO $connection;
    public \PDOStatement $statement;

    public function __construct()
    {
        $host = DB['host'];
        $name = DB['name'];
        $charset = DB['charset'];
        $dsn = "mysql:host=" . $host . ";dbname=" . $name . ";charset=" . $charset;
        try {
            $username = DB['username'];
            $password = DB['password'];
            $options = DB['options'];
            $this->connection=new \PDO($dsn, $username, $password, $options);
        } catch (\PDOException) {

        }
    }

}