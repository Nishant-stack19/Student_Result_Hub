<?php
// Database connection parameters
$servername = "localhost"; // Your database server, usually 'localhost'
$username = "root";        // Your MySQL username, default is 'root' for XAMPP
$password = "";            // Your MySQL password, default is an empty string for XAMPP
$database = "student_result_manage_db";        // The name of your database

// Create a connection to the MySQL database
try {
    $connect = new mysqli($servername, $username, $password, $database);

    // Check if the connection was successful
    if ($connect->connect_error) {
        throw new Exception("Connection failed: " . $connect->connect_error);
    }
} catch (Exception $e) {
    // Handle connection errors
    echo "<script>alert('Database connection failed: " . $e->getMessage() . "');</script>";
    exit; // Stop further execution if the connection fails
}
?>