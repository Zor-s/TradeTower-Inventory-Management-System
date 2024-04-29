<?php

class connector
{
    public $conn;
    public function __construct()
    {
        $servername = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'tradetower';
        $this->conn  = new mysqli($servername, $username, $password, $dbname);
        if ($this->conn->connect_error) {
            die('Connection Failed: ' . $this->conn->connect_error);
        }

    }
}
