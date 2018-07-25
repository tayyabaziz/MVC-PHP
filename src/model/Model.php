<?php
namespace RecipeSystem\Model;

use mysqli;

include __DIR__.'/../../config.php';

class Model
{
    private $_connection;
    

    function __construct() 
    {
        $this->_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    
        // Error handling
        if(mysqli_connect_error()) 
        {
            trigger_error("Failed to conencto to MySQL: " . mysqli_connect_error(),
                 E_USER_ERROR);
        }
    }

    public function query($query) 
    {
        return $this->_connection->query($query) or die("Failed to conencto to MySQL: " . mysqli_error($this->_connection));
    }

    public function insert_id() 
    {
        return $this->_connection->insert_id;
    }

    public function getSpecific($results, $value) 
    {
        if(mysqli_num_rows($results)) 
        {
            while($obj = $results->fetch_object()) 
            {
                return $obj->{$value};
            }
        }
        return false;
    }

    public function getData($results) 
    {
        if(mysqli_num_rows($results)) 
        {
            while($obj = $results->fetch_object()) 
            {
                return $obj;
            }
        }
        return false;
    }

    public function getWholeData($results) 
    {
        $finalarr = array();
        if(mysqli_num_rows($results)) 
        {
            while($obj = $results->fetch_object()) 
            {
                $finalarr[] = $obj;
            }
        }
        return $finalarr;
    }
}