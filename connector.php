<?php

class connector
{
    
    public function __construct()
    {
        $servername = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'tradetower';
        $conn  = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die('Connection Failed: ' . $conn->connect_error);
        }

    }
}
