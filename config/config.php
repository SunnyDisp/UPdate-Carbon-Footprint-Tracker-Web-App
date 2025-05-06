<?php
    // Database configuration
    $db_server = 'localhost';
    $db_username = 'root';
    $db_password = '';
    $db_name = 'carbon_tracker_db';

    // Enable MySQLi error reporting
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // Try to establish a connection to the database
    try {
        $conn = new mysqli($db_server, $db_username, $db_password, $db_name);
        $conn->set_charset("utf8mb4");
    }

    // Catch exception if connection fails
    catch (mysqli_sql_exception $e) {
        die("Connection failed: " . $e->getMessage());
    }
?>