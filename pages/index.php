<?php
    // Start the session with database config
    session_start();
    require_once '../config/config.php';
    $error = null;

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // Validate username and password
        if (empty($username) || empty($password)) {
            $error = "Username and password are required.";
        } else {
            // Prevent SQL injection
            $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                // Verify password
                if (password_verify($password, $row['password'])) {
                    // Set session variables
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['username'] = $username;

                    // Redirect to the activity page
                    header("Location: home.php");
                    exit();
                } else {
                    $error = "Invalid username or password";
                }
            } else {
                $error = "Invalid username or password";
            }
            
            // Close the prepared statement and database connection
            $stmt->close();
            $conn->close();
        }
    }
?>

<!-- HTML for the Login Page -->
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
                        } 
                    ?>

                <!-- Ask user input -->
                <form method="POST" action="">
                    <input type="text" name="username" placeholder="Username" class="col2-form form_user" required>
                    <input type="password" name="password" placeholder="Password" class="col2-form form_pass" required>
                    <input type="submit" name="submit" value="Sign In" class="form_submit">
                    
                    <p class="form_par">Don't have an account? <a href="register.php">Sign Up</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
