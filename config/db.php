<?php   
    session_start();
    $host       = "localhost";  
    $user       = "root";  
    $password   = 'root';  
    $db_name    = "phpbasics";  
      
    $db = mysqli_connect($host, $user, $password, $db_name);  
    if(mysqli_connect_errno()) {  
        die("Failed to connect with MySQL: ". mysqli_connect_error());  
    }  

    global $db;
    // Include config file
    require_once "sanitization.php";
    require_once "functions.php";
?>  