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

    public function getOne(): array|false
    {
        return $this->statement->fetch();
    }

    public function findPostBySlug($slug)
    {
        return db()->query("SELECT * FROM posts WHERE slug =?", [$slug])->getOne();
    }

    public function findAll($table): array|false
    {
        $this->query("SELECT * FROM {$table}");
        return $this->statement->fetchAll();
    }

    public function findById($table, $id)
    {
        $this->query("select * from {$table} where id = ? limit 1", [$id]);
        return $this->statement->fetch();
    }

    public function getColumn(): mixed
    {
        return $this->statement->fetchColumn();
    }

    public function findUnique($table, $field, $value)
    {
        $this->query("select * from {$table} where {$field} = ? limit 1", [$value]);
        return $this->statement->fetch();

    }

    public function findUniqueWithExclude($table, $data_fields, $value, $currentId)
    {
        //       при апдейте проверяет по всем записям кроме текущего ( которое указано в поле currentId)
        $this->query("select {$data_fields[0]}
                            from {$table}
                            where {$data_fields[0]} = ? 
                            AND {$data_fields[1]} !=? limit 1", [$value, $currentId]);
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

    public function count($table)
    {
        $this->query("select count(*) from {$table}");
        return $this->getColumn();
    }

    public function getQueries(): array
    {
        $res = [];
        foreach ($this->queries as $k => $query) {

            //            PHP_EOL = маркер конца строки в зависимости от ОСи
            $line = strtok($query, PHP_EOL);
            while ($line !== false) {
                if (str_contains($line, 'SQL:') || str_contains($line, 'Sent SQL:')) {
                    $res[$k][] = $line;
                }
                $line = strtok(PHP_EOL);
            }
        }

        return $res;
    }

}