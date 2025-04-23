<?php
    session_start();
    require_once '../config/config.php';

    // Redirect if not logged in
    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }

    // Get current user's ID
    $username = $_SESSION['username'];
    $user_stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $user_stmt->bind_param("s", $username);
    $user_stmt->execute();
    $user_id = $user_stmt->get_result()->fetch_assoc()['id'];
    $user_stmt->close();

    // Fetch categories from emissions table
    $categories_stmt = $conn->prepare("SELECT id, category FROM categories");
    $categories_stmt->execute();
    $categories_result = $categories_stmt->get_result();

    // Fetch emissions grouped by category
    $activities_by_category = [];
    $category_stmt = $conn->prepare("
        SELECT e.*, u.unit
        FROM emissions e
        JOIN units u ON e.unit_id = u.id
        WHERE e.category_id = ?
    ");

    while ($category = $categories_result->fetch_assoc()) {
        $category_id = $category['id'];
        $category_stmt->bind_param("i", $category_id);
        $category_stmt->execute();
        $emissions_result = $category_stmt->get_result();
        $activities_by_category[$category_id] = $emissions_result->fetch_all(MYSQLI_ASSOC);
    }
    $category_stmt->close();
    $categories_result->data_seek(0); 

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['activity-submit'])) {
        $emission_id = $_POST['activity-specific'] ?? '';
        $quantity = floatval($_POST['activity-unit'] ?? 0);

        if (!empty($emission_id) && $quantity > 0) {
            $emission_stmt = $conn->prepare("SELECT emission_per_unit FROM emissions WHERE id = ?");
            $emission_stmt->bind_param("i", $emission_id);
            $emission_stmt->execute();
            $emission_data = $emission_stmt->get_result()->fetch_assoc();
            $emission_stmt->close();

            if ($emission_data) {
                $activity_emission = $quantity * $emission_data['emission_per_unit'];

                $insert_stmt = $conn->prepare("INSERT INTO activity_logs (user_id, emission_id, emission_generated) VALUES (?, ?, ?)");
                $insert_stmt->bind_param("iid", $user_id, $emission_id, $activity_emission);
                $insert_stmt->execute();
                $insert_stmt->close();

                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
        }
    }

    // Get today's total emission
    $today_stmt = $conn->prepare("
        SELECT SUM(emission_generated) AS daily_total 
        FROM activity_logs 
        WHERE user_id = ? AND DATE(date_logged) = CURDATE()
    ");

    $today_stmt->bind_param("i", $user_id);
    $today_stmt->execute();
    $daily_total = $today_stmt->get_result()->fetch_assoc()['daily_total'] ?? 0;
    $today_stmt->close();

    // Get average daily emission
    $avg_stmt = $conn->prepare("
        SELECT AVG(daily_emission) AS avg_daily_emission
        FROM (
            SELECT DATE(date_logged) AS log_date, SUM(emission_generated) AS daily_emission
            FROM activity_logs
            WHERE user_id = ?
            GROUP BY DATE(date_logged)
        ) AS daily_totals
    ");

    $avg_stmt->bind_param("i", $user_id);
    $avg_stmt->execute();
    $average_daily_emission = round($avg_stmt->get_result()->fetch_assoc()['avg_daily_emission'] ?? 0, 3);
    $avg_stmt->close();
?>

<!-- HTML for Activity Page -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>UPdate.</title>
</head>

<body>
    <div class="app-container">
        <?php include '../includes/header.php'; ?>

        <!-- Activity Container -->
        <div class="activity-container">

            <!-- Form Column -->
            <div class="activity-col1">

                <!-- Form Title -->
                <div class="activity-title">
                    <h2 class="activity-heading">Log Your Daily Activities</h2>
                    <h3 class="activity-subheading">Track your daily actions and help reduce your carbon footprint.</h3>
                </div>
                
                <!-- Form Body -->
                <form action="" method="POST">
                    <div class="col1-form">

                        <!-- Category div -->
                        <div class="group">
                            <h3>Select Category</h3>
                            <select name="activity-category" id="activity-category" required>
                                <?php 
                                    $categories_result->data_seek(0);

                                    while ($row = $categories_result->fetch_assoc()) {
                                        $cat_id = $row['id'];
                                        $cat_name = htmlspecialchars($row['category']);
                                        echo "<option value=\"$cat_id\">$cat_name</option>";
                                    }    
                                ?>
                            </select>
                        </div>
                    
                        <!-- Activity div -->
                        <div class="group">
                            <h3>Select Activity</h3>
                            <select name="activity-specific" id="activity-specific" required></select>
                        </div>

                        <!-- Unit div -->
                        <div class="group">
                            <h3>Enter Number of <span id="unit-label">Unit</span>s</h3>
                            <input type="number" name="activity-unit" id="activity-unit" step="any" placeholder="e.g. 4.12" required>
                        </div>
                        
                        <!-- Estimated Emissions div -->
                        <div class="group">
                            <h3>Estimated Emissions (kg CO₂)</h3>
                            <input type="text" name="activity-emission" id="activity-emission" readonly>
                        </div>

                        <!-- Activity notes div -->
                        <div class="group">
                            <h3>Description</h3>
                            <input type="text" name="activity-notes" id="activity-notes" readonly>
                        </div>

                        <!-- Submit button -->
                        <input type="submit" name="activity-submit" value="Calculate your daily emission" class="activity-submit">
                    </div>
                </form>
            </div>

            <!-- Result Column -->
            <div class="activity-col2">

                <!-- Total Emission Today Section -->
                <div class="activity-total">
                    <?php
                        $today_stmt = $conn->prepare("SELECT SUM(emission_generated) AS daily_total FROM activity_logs WHERE user_id = ? AND DATE(date_logged) = CURDATE()");
                        $today_stmt->bind_param("i", $user_id);
                        $today_stmt->execute();
                        $result = $today_stmt->get_result();
                        $row = $result->fetch_assoc();
                        $daily_total = $row['daily_total'] ?? 0;
                    ?>

                    <h2 class="activity-heading"><?= round($daily_total, 3) ?> kg CO₂</h2>
                    <h3 class="activity-subheading">is your estimated total emission today, while your average daily emission is <?= $average_daily_emission ?> kg CO₂.</h3>
                </div>

                <!-- Suggestions Section -->
                <div class="activity-suggestion">
                    <?php
                        $ideal_daily_emission = 13.7;
                        $difference = round($daily_total - $ideal_daily_emission, 3);

                        if ($difference > 0) {
                            echo "<h3>Lower your emissions by {$difference} kg</h3>";
                    ?>
                        <p class="suggestion-subheading">to reduce greenhouse emissions and carve the path to net zero. Here's how: </p>
                        <ul>
                            <li>Use public transportation, cycle, or carpool whenever possible.</li>
                            <li>Turn off lights and appliances when not in use and switch to energy-efficient bulbs.</li>
                            <li>Recycle, compost, and avoid single-use plastics.</li>
                            <li>Choose local, plant-based foods and reduce meat and dairy intake.</li>
                            <li>Fix leaks, use water-saving fixtures, and avoid leaving taps running unnecessarily.</li>
                        </ul>

                    <?php
                        } else {
                            echo '<h3 style="text-align: center; font-size: 1.5rem">You\'re under the ideal limit by ' . abs($difference) . ' kg CO₂. Keep it up!</h3>' ;
                        }
                    ?>
                </div>

                <!-- Bottom image section -->
                <div class="col2-photo"></div>
            </div>
        </div>

        <?php include '../includes/footer.php'; ?>
    </div>

    <!-- JS Section -->
    <script>const activitiesByCategory = <?php echo json_encode($activities_by_category); ?>;</script>
    <script src="../assets/js/script.js"></script>

</body>
</html>


<?php 
    // Close the connection
    $conn->close(); 
?>