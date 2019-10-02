<?php

class ORM
{
    private $_db;
    public function __construct()
    {
        $dsn = 'mysql:dbname=blog2;host=localhost';
        $user = 'root';
        $password = 'root';

        $this->_db = new PDO($dsn, $user, $password);
    }

    public function insert($table, $fields = [])
    {
        if (count($fields) > 0) {
            $sql = "INSERT INTO $table ";
            $sql .= "(" . implode(', ', array_keys($fields)) .") ";
            $sql .= "VALUES (" . implode(', ', array_map(function ($p) {
                return ":$p";
            }, array_keys($fields))) . ")";
            $query = $this->_db->prepare($sql);
            foreach ($fields as $p => $v) {
                $query->bindValue(":$p", $v);
            }
            $query->execute();
            return $this->_db->lastInsertId();
        } else {
            return null;
        }
    }

    public function update($table, $condition = [], $fields = [])
    {
        $sql = "UPDATE $table SET ";
        $first = true;
        foreach ($fields as $p => $v) {
            if ($first === false) {
                $sql .= ", ";
            } else {
                $first = false;
            }
            $sql .= "$p = :$p ";
        }
        $sql .= "WHERE 1" . $this->formatCondition($condition);
        $query = $this->_db->prepare($sql);
        foreach ($fields as $p => $v) {
            $query->bindValue(":$p", $v);
        }
        $this->bindCondition($query, $condition);
        $query->execute();
        return $query->rowCount();
    }

    public function delete($table, $condition = [])
    {
        $sql = "DELETE FROM $table WHERE 1" . $this->formatCondition($condition);
        $query = $this->_db->prepare($sql);
        $this->bindCondition($query, $condition);
        $query->execute();
        return $query->rowCount();
    }

    public function find($table, $condition = [])
    {
        $sql = "SELECT * FROM  $table WHERE 1" . $this->formatCondition($condition);
        $query = $this->_db->prepare($sql);
        $this->bindCondition($query, $condition);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    private function formatCondition($condition = [])
    {
        $sql = "";
        foreach ($condition as $p => $v) {
            $sql .= " AND $p = :cond_$p";
        }
        return $sql;
    }

    private function bindCondition(&$query, $condition = [])
    {
        foreach ($condition as $p => $v) {
            $query->bindValue(":cond_$p", $v);
        }
    }
}