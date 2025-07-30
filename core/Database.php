<?php

namespace PHPFramework;

class Database
{
    protected \PDO $connection;
    protected \PDOStatement $statement;
    protected array $queries = [];

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
            if (DEBUG) {
                ob_start();
                $this->statement->debugDumpParams();
                $this->queries[] = ob_get_clean();
            }
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

    public function getInsertId(): false|string
    {
        return $this->connection->lastInsertId();
    }

    public function rowCount(): int
    {
        return $this->statement->rowCount();
    }

    public function getQueries(): array
    {
        $res = [];
        foreach ($this->queries as $k => $query) {

            //            PHP_EOL = маркер конца строки в зависимости от ОСи
            $line = strtok($query, PHP_EOL);
            while ($line !== false) {
                if(str_contains($line,'SQL:') || str_contains($line,'Sent SQL:')) {
                    $res[$k][]=$line;
                }
                $line=strtok(PHP_EOL);
            }
        }

        return $res;
    }

}