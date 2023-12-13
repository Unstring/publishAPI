<?php

$servername = "127.0.0.1"; // Replace 'localhost' with your MySQL server address if needed
$username = "fracuvcm_paper_api"; // Replace 'your_username' with your MySQL username
$password = "s8j]X:7/eK"; // Replace 'your_password' with your MySQL password
$dbname = "fracuvcm_paper_api"; // Replace 'your_database' with your desired database name

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully or already exists<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select the database
$conn->select_db($dbname);

// Read SQL file
$sqlFile = 'db.sql'; // Replace 'db.sql' with the path to your SQL file

$sqlContent = file_get_contents($sqlFile);

// Execute multi-query SQL commands
if ($conn->multi_query($sqlContent)) {
    echo "SQL commands executed successfully<br>";
} else {
    echo "Error executing SQL commands: " . $conn->error . "<br>";
}

// Close the connection
$conn->close();
?>
