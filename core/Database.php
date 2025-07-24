<?php

namespace PHPFramework;

class Database
{
    protected \PDO $connection;
    protected \PDOStatement $statement;

    public function __construct()
    {
        $host = DB['host'];
        $name = DB['dbname'];
        $charset = DB['charset'];
        $dsn = "mysql:host=" . $host . ";dbname=" . $name . ";charset=" . $charset;
        try {
            $username = DB['username'];
            $password = DB['password'];
            $options = DB['options'];
            $this->connection = new \PDO($dsn, $username, $password, $options);
        } catch (\PDOException $error) {
            error_log(
                "[" . date('Y-m-d H:i:s') . "] DB Error: {$error->getMessage()}" . PHP_EOL,
                3,
                ERROR_LOG_FILE);
            abort($error->getMessage(), 500);
        }
        //        return $this;
    }

    public function query(string $query, array $params = [])
    {
        try {
            $this->statement = $this->connection->prepare($query);
            $this->statement->execute($params);
        } catch (\PDOException $e) {
            error_log(
                "[" . date('Y-m-d H:i:s') . "] DB Error: {$e->getMessage()}" . PHP_EOL,
                3,
                ERROR_LOG_FILE);
            abort($e->getMessage(), 500);
        }
        return $this;
    }

    public function get(): array|false
    {
        return $this->statement->fetchAll();
    }

    public function findAll($table): array|false
    {
        $tableList = ["posts"];
        if (!in_array($table, $tableList, true)) {
            abort("Таблица '{$table}' не разрешена для выборки.", 403);
        }
        $this->query("SELECT * FROM {$table}");
        return $this->statement->fetchAll();
    }

    public function findById($table, $id)
    {
        $this->query("select * from {$table} where id = ? limit 1", [$id]);
        return $this->statement->fetch();
    }

    public function findByIdOrFail($table, $id)
    {
        $result = $this->findById($table, $id);
        if (!$result) {
            abort("id: {$id} not found in table: {$table}"
            );
        }
        return $result;
    }

    public function getInsertId():false|string
    {
        return $this->connection->lastInsertId();
    }

    public function rowCount():int
    {
        return $this->statement->rowCount();
    }

}