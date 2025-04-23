<?php
    // Start the session with database config
    session_start();
    require_once '../config/config.php';
    $error = null;
    $success = null;

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
        $f_name = trim($_POST['f_name']);
        $l_name = trim($_POST['l_name']);
        $email = trim($_POST['email']);
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // Check if username already exists
        $check_stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        // If username already exists
        if ($check_result->num_rows > 0) {
            $error = "Username already exists. Please choose another one.";
        } else {
            // Else, insert into users table
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (f_name, l_name, email, username, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $f_name, $l_name, $email, $username, $hashed_password);

            if ($stmt->execute()) {
                $success = "Account created successfully! You can now log in.";
            } else {
                $error = "Error:" . $stmt->error;
            }

            $stmt->close();
        }
        
        // Close the prepared statement and database connection
        $check_stmt->close();
        $conn->close();
    }
?>

<!-- HTML for the Register Page -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>UPdate.</title>
</head>

<body>
    <div class="container">
        <!-- Image Column -->
        <div class="col1"></div>

        <!-- Form Column -->
        <div class="col2">

            <!-- Form Title and Description -->
            <div class="col2-title">
                <h1 class="update">UPdate</h1>
                <p>Track your carbon footprint and build better habits with UPdate — the University of the Philippines’ Carbon Footprint Tracker.</p>
            </div>

            <!-- Form Body -->
            <div class="col2-body">

                <!-- PHP script to display error message -->
                <?php 
                    if ($error !== null) {
                        echo '<p class="error-message">' . htmlspecialchars($error) . '</p>'; 
                    } else {
                        echo '<p class="success-message">' . htmlspecialchars($success) . '</p>';
                    }
                ?>

                <!-- Ask user input -->
                <form method="POST" action="">

                    <div class="col2-body-name">
                        <input type="text" name="f_name" placeholder="First Name" class="col2-form fname" required>
                        <input type="text" name="l_name" placeholder="Last Name" class="col2-form lname" required>
                    </div>

                    <input type="email" name="email" placeholder="Email Address" class="col2-form email" required>
                    <input type="text" name="username" placeholder="Username" class="col2-form form_user" required>
                    <input type="password" name="password" placeholder="Password" class="col2-form form_pass" required>
                    <input type="submit" name="submit" value="Sign Up" class="form_submit">

                    <p class="form_par">Already have an account? <a href="index.php">Sign In</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
