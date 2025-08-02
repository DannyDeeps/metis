<?php namespace Metis\ORM;

abstract class PdoAdaptor
{
    const DEF_OPTIONS= [
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    /** @var PDO $pdo PDO Instance */
    protected $pdo= null;

    /** @var string $host Database host name */
    protected $dsn= null;

    /** @var array $options Database connection options */
    protected $options= null;

    /** @var int $retryMax Maximum reconnect attempts allowed */
    protected $reconnectAttemptsMax= 100;

    /** @var int $reconnectAttempts Reconnection attempts */
    protected $reconnectAttempts= 0;

    /** @var array $reconnectErrors Which PDOException codes trigger a reconnect */
    protected $reconnectErrors= [ 1317, 2002, 2006 ];

    /** @var int $reconnectDelay Time to delay between reconnect attempts in milliseconds */
    protected $reconnectDelay= 500;

    public function __construct()
    {
        if (!defined('ENV'))
        {
            throw new \Exception("Environment not defined");
        }

        if (empty($this->database))
        {
            throw new \Exception("Missing database");
        }

        if (empty($this->user))
        {
            throw new \Exception("Missing database user name");
        }

        if (empty($this->password))
        {
            throw new \Exception("Missing database password");
        }

        if (empty($this->host))
        {
            throw new \Exception("Missing database host name");
        }

        if (empty($this->charset))
        {
            throw new \Exception("Missing database character set");
        }

        switch (ENV)
        {
            case 'production': break;
            case 'development': $this->database .= '_dev'; break;
            case 'testing': $this->database .= '_test'; break;
            default:
                throw new \Exception("Unknown environment");
        }

        $this->dsn= "mysql:host={$this->host};dbname={$this->database};charset={$this->charset}";
        $this->options= array_replace(self::DEF_OPTIONS, $this->options);

        return $this;
    }

    protected function getConnection()
    {
        if (empty($this->pdo))
        {
            $this->pdo= new \PDO($this->dsn, $this->user, $this->password, $this->options);
        }

        return $this->pdo;
    }

    protected function reconnect()
    {
        $connected= false;
        while (!$connected && $this->reconnectAttempts < $this->reconnectAttemptsMax)
        {
            usleep($this->reconnectDelay * 1000);
            ++$this->reconnectAttempts;
            $this->pdo= null;

            try
            {
                if ($this->getConnection())
                {
                    $connected= true;
                }
            }
            catch (\Exception $exc) {}
        }

        if (!$connected)
        {
            throw $exc;
        }
    }

    public function select(string $table, array $fields= [], mixed $filters= null, int $limitBy= null, string $orderBy= null)
    {
        $select= '*';
        if (!empty($fields))
        {
            $select= '`' . implode('`,`', $fields) . '`';
        }

        $where= [];
        $params= [];
        if (!empty($filters))
        {
            if (is_string($filters))
            {
                $where= "WHERE $filters";
            }

            if (is_array($filters))
            {
                foreach ($filters as $field => $data)
                {
                    $where[]= "`$field` = :$field";
                    $params[$field]= $data;
                }

                $where= 'WHERE ' . implode(' AND ', $where);
            }
        }

        $sql= "SELECT $select FROM `$table` ";
        if (!empty($where))
        {
            $sql .= $where;
        }

        if (!empty($orderBy))
        {
            $sql .= " ORDER BY $orderBy";
        }

        if (!empty($limitBy))
        {
            $sql .= " LIMIT $limitBy";
        }

        $conn= $this->getConnection();

        try
        {
            $stmt= $conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        }
        catch (\Exception $exc)
        {
            if (!empty($exc->errorInfo[1]) && in_array($exc->errorInfo[1], $this->reconnectErrors))
            {
                try
                {
                    $this->reconnect();
                }
                catch (\Exception $exc2) {}

                return $this->select($table, $fields, $filters, $limitBy, $orderBy);
            }

            throw $exc;
        }
    }

    public function insert(string $table, array $insert)
    {
        $sets= [];
        $params= [];

        foreach ($insert as $field => $data)
        {
            $sets[]= "`$field` = :$field";
            $params[$field]= $data;
        }

        $sets= implode(',', $sets);
        $sql= "INSERT INTO $table SET $sets";

        $conn= $this->getConnection();
        try
        {
            $stmt= $conn->prepare($sql);
            $stmt->execute($params);
            return $conn->lastInsertId();
        }
        catch (\Exception $exc)
        {
            if (!empty($exc->errorInfo[1]) && in_array($exc->errorInfo[1], $this->reconnectErrors))
            {
                try
                {
                    $this->reconnect();
                }
                catch (\Exception $exc2) {}

                return $this->insert($table, $insert);
            }
            throw $exc;
        }
    }

    public function update(string $table, array $update, mixed $filters= null)
    {
        $sets= [];
        $params= [];

        foreach ($update as $field => $data)
        {
            $sets[]= "`$field` = :set_$field";
            $params["set_$field"]= $data;
        }

        $sets= implode(',', $sets);

        if (!empty($filters))
        {
            if (is_string($filters))
            {
                $where= "WHERE $filters";
            }

            if (is_array($filters))
            {
                $where= [];

                foreach ($filters as $field => $data)
                {
                    $where[]= "`$field` = :where_$field";
                    $params["where_$field"]= $data;
                }

                $where= 'WHERE ' . implode(' AND ', $where);
            }
        }

        $sql= "UPDATE $table SET $sets $where";

        $conn= $this->getConnection();

        try
        {
            $stmt= $conn->prepare($sql);
            $stmt->execute($params);
            return $conn->lastInsertId();
        }
        catch (\Exception $exc)
        {
            if (!empty($exc->errorInfo[1]) && in_array($exc->errorInfo[1], $this->reconnectErrors))
            {
                try
                {
                    $this->reconnect();
                }
                catch (\Exception $exc2) {}

                return $this->update($table, $update, $filters);
            }

            throw $exc;
        }
    }

    public function delete(string $table, mixed $filters= null)
    {
        if (!empty($filters))
        {
            if (is_string($filters))
            {
                $where= "WHERE $filters";
            }

            if (is_array($filters))
            {
                $where= [];
                $params= [];

                foreach ($filters as $field => $data)
                {
                    $where[]= "`$field` = :$field";
                    $params[$field]= $data;
                }

                $where= 'WHERE ' . implode(' AND ', $where);
            }
        }

        $sql= "DELETE FROM $table $where";

        $conn= $this->getConnection();

        try
        {
            $stmt= $conn->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        }
        catch (\Exception $exc)
        {
            if (!empty($exc->errorInfo[1]) && in_array($exc->errorInfo[1], $this->reconnectErrors))
            {
                try
                {
                    $this->reconnect();
                }
                catch (\Exception $exc2) {}

                return $this->delete($table, $filters);
            }

            throw $exc;
        }
    }

    public function describeTable(string $table)
    {
        $describeTableSql= "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '{$this->database}' AND TABLE_NAME = '$table' ORDER BY ORDINAL_POSITION";

        $conn= $this->getConnection();

        try
        {
            $query= $conn->query($describeTableSql);
            return $query->fetchAll();
        }
        catch (\Exception $exc)
        {
            if (!empty($exc->errorInfo[1]) && in_array($exc->errorInfo[1], $this->reconnectErrors))
            {
                try
                {
                    $this->reconnect();
                }
                catch (\Exception $exc2) {}

                return $this->describeTable($table);
            }

            throw $exc;
        }
    }
}