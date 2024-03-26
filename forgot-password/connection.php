<?php

// Database Configuration
$hostname = 'localhost'; // Change this to your MySQL hostname
$username = 'root'; // Change this to your MySQL username
$password = ''; // Change this to your MySQL password
$database = 'ovas_db'; // Change this to your MySQL database name

// Create connection
$con = mysqli_connect($hostname, $username, $password, $database);

// Check connection
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

?>