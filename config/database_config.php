<?php

/**
 * Database config file.
 */

$servername = 'localhost';
$username = 'root';
$password = 'mindfire';
$dbname = 'registration';

// Create connection.
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection.
if ($conn->connect_error) {
    header('Location: error.php');
}
