<?php

namespace App\DB\Connection;

use Exception;
use PDO;
use PDOException;

class MySQL
{
    /**
     * @var array
     */
    private static $instances = [];

    /**
     * @var PDO|null
     * 
     * DB conccection
     */
    private $conn = null;

    public static function getInstance()
    {
        $subclass = static::class;
        if (!isset(self::$instances[$subclass])) {
            self::$instances[$subclass] = new static;
        }
        return self::$instances[$subclass];
    }

    private function __construct()
    {
        $servername = "mysql-infuse";
        $database   = "db";
        $username   = "user";
        $password   = "password";

        try {
            $this->conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function select(string $sql)
    {
        try {
            $db = $this->conn->prepare($sql);
            $db->execute();
            $result = $db->fetchAll();
            return $result;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function insertOrUpdate(string $sql, array $data)
    {
        try {
            $db = $this->conn->prepare($sql);
            foreach ($data as $field => $value) {
                $db->bindValue(":$field", $value);
            }
            $db->execute();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
