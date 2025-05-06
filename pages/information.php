<?php
    session_start();
    require_once '../config/config.php';

    // If not logged in, redirect to Login Page
    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }
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
    <?php include '../includes/header.php'; ?>

    <div class="carbon-container">
        <div class="video-title">
            <h2>What is a carbon footprint?</h2>
        </div>

        <div class="video-body">
            <div class="video-description">
                <p>A carbon footprint is an environmental indicator that measures the amount of greenhouse gases, released directly or indirectly as a result of specific activities. Every person, product, and organization has a carbon footprint. For individuals, it is determined by their consumption patterns and lifestyle choices, including transportation, electricity use, dietary habits, and daily routines. The larger the footprint, the greater the impact on the Earth's atmosphere and climate.</p>
                <p>So, if nearly everything we do contributes to emissions, what steps can we take to reduce our daily carbon footprint? While responsible consumption is a key factor, we can make an even greater impact by protecting nature’s most effective carbon sinks—forests, grasslands, mangroves, and marshes—which store vast amounts of carbon. Additionally, we can adopt practical, eco-friendly habits in our everyday lives, such as consuming local and seasonal products, using energy-efficient appliances, conserving water and electricity and opting for sustainable modes of transportation. By making these small changes, we can collectively lower our emissions and help prevent the worst effects of climate change.</p>
                <p>The UPdate Carbon Footprint Tracker was created to empower individuals to monitor their daily carbon emissions and build more sustainable habits. Through visual tracking and real-time feedback, users become more aware of their environmental impact and are encouraged to make better choices. Carbon footprinting is an essential step toward achieving sustainable development. Hence, as individuals, we each have a role to play in safeguarding our planet. By choosing to live responsibly and sustainably, we can reduce our ecological footprint and protect the only Earth we have.</p>
            </div>

            <div class="video-container">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/YseZXKfT_yY?si=FcsLgygRzY_tZ5HJ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div> 
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>


<?php 
    // Close the connection
    $conn->close(); 
?>