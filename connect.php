<?php
    try {
        $server="localhost";
        $username="u111937156_adnan2";
        $password="Waasil@2009";   
        $database="u111937156_kokanir";
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