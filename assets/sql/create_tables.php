<?php
// Start the session with database config
session_start();
require_once '../../config/config.php';
$error = null;

// Create database tables
$sql = "
    CREATE TABLE categories (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        category VARCHAR(30) NOT NULL
    );

    CREATE TABLE units (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        unit VARCHAR(30) NOT NULL
    );

    CREATE TABLE emissions (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        category_id INT(6) UNSIGNED,
        activity VARCHAR(100) NOT NULL,
        unit_id INT(6) UNSIGNED,
        emission_per_unit FLOAT,
        remarks TEXT,
        FOREIGN KEY (category_id) REFERENCES categories(id),
        FOREIGN KEY (unit_id) REFERENCES units(id)
    );

    CREATE TABLE users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        f_name VARCHAR(50) NOT NULL,
        l_name VARCHAR(50) NOT NULL,
        email VARCHAR(50) NOT NULL,
        username VARCHAR(100) NOT NULL,
        password VARCHAR(100) NOT NULL
    );

    CREATE TABLE activity_logs (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id INT(6) UNSIGNED,
        emission_id INT(6) UNSIGNED,
        emission_generated FLOAT,
        date_logged TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (emission_id) REFERENCES emissions(id)
    );
";

if ($conn->multi_query($sql) === TRUE) {
    echo "Tables created successfully";

    // Clear remaining results from multi_query
    do {
    } while ($conn->more_results() && $conn->next_result());

} else {
    echo "Error creating tables: " . $conn->error;
}

$conn->close();
?>
