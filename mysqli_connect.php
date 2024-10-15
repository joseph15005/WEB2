<?php
// Create a connection to the admin_db database and set the encoding
$databaseHost = 'localhost';
$databaseName = 'admin_db';
$databaseUsername = 'root';
$databasePassword = '';

// Make the connection:
$dbcon = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName); 
mysqli_set_charset($dbcon, 'utf8'); //Set the encoding
