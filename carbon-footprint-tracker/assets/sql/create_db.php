<?php
    // Start the session with database config
    session_start();
    require_once '../../config/config.php';
    $error = null;

    // Create database
    $sql = "CREATE DATABASE carbon_tracker_db";
    
    if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
    } else {
    echo "Error creating database: " . $conn->error;
    }

    $conn->close();
?>