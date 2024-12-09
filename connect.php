<?php
    try {
        $server="localhost";
        $username="u111937156_adnan";
        $password="Waasil@2009";   
        $database="u111937156_kokani";
        $conn = new mysqli($server,$username,$password,$database);  //connecting database
    
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error); //exception occured
        }
    } catch (Exception $e) {
        // Handle connection error
        echo "Error: " . $e->getMessage();
        exit();
    }
?>          