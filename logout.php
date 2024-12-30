<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"]!=true){
    header("location: index.php");
    exit;

}
session_destroy(); // Destroy session data
setcookie("remember_me", "", time() - 3600, "/"); // Expire the cookie
session_destroy();
header("location: index.php");






?>