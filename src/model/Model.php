<?php

namespace RecipeSystem\Model;

use mysqli;

class Model
{
    private $_connection;

    public function __construct()
    {
        $this->_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        // Error handling
        if (mysqli_connect_error()) {
            die('Failed to connect to MySQL: '.mysqli_error($this->_connection));
        }
    }

    public function getConnection()
    {
        return $this->_connection;
    }

    public function insert($table, $fields, $values, $data)
    {
        $query = "INSERT INTO $table (".implode(', ', $fields).") VALUES ('".implode("', '", $values)."')";
        $this->query($query, $data);

        return $this->insert_id();
    }

    public function select($fields = "*", $table, $data, $where = "", $groupby = "", $orderby = "", $limit = "")
    {
        if ($where != "") {
            $where .= "WHERE ".$where;
        }
        $query = "SELECT $fields $table $where $groupby $orderby $limit";
        return $this->query($query, $data);
    }

    public function update($table, $fieldsvalues, $where, $data)
    {
        if ($where != "") {
            $where .= "WHERE ".$where;
        }
        $fieldquery = "";
        foreach ($fieldsvalues as $key => $value) {
            $fieldquery = $key."=''".$value."'";
        }
        $query = "UPDATE $table SET $fieldquery $where";
        return $this->query($query, $data);
    }

    public function delete($table, $where, $data)
    {
        if ($where != "") {
            $where .= "WHERE ".$where;
        }
        $query = "DELETE FROM $table $where";
        return $this->query($query, $data);
    }

    public function query($query, $data = '')
    {
        if ('' != $data) {
            foreach ($data as $key => $value) {
                $query = str_replace($key, $value, $query);
            }
        }

        return $this->_connection->query($query) or die('Failed to connect to MySQL: '.mysqli_error($this->_connection));
    }

    public function insert_id()
    {
        return $this->_connection->insert_id;
    }

    public function getSpecific($results, $value)
    {
        if (mysqli_num_rows($results)) {
            while ($obj = $results->fetch_object()) {
                return $obj->{$value};
            }
        }

        return false;
    }

    public function getData($results)
    {
        if (mysqli_num_rows($results)) {
            while ($obj = $results->fetch_object()) {
                return $obj;
            }
        }

        return false;
    }

    public function getWholeData($results)
    {
        $finalarr = array();
        if (mysqli_num_rows($results)) {
            while ($obj = $results->fetch_object()) {
                $finalarr[] = $obj;
            }
        }

        return $finalarr;
    }
}
