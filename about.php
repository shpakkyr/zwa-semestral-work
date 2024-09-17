<?php
    require "app/database/db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="frontend/css/header-footer.css">
    <link rel="stylesheet" href="frontend/css/about.css">
    <link rel="icon" type="image/x-icon" href="frontend/img/black.png">
</head>
<body>

<?php include 'app/include/header.php'; ?>
<div class="about-section">
    <h2>Welcome to FitnessHub</h2>
    <p class="description">
        FIT Courses is your ultimate destination for fitness and bodybuilding courses. Whether you're a beginner
        looking to kickstart your fitness journey or an experienced enthusiast, our platform provides a space for
        users to create and share their own courses. Join our community and embark on a path to a healthier and
        stronger you! On this website you can create course of 4 categories: Fitness, Body-building, Cross-fit and Active sport.
    </p>

    <h2>Fishing Rules</h2>
    <ul class="fishing-rules">
        <li>Respect the environment and practice responsible fishing.</li>
        <li>Adhere to catch limits and size regulations to preserve fish populations.</li>
        <li>Properly dispose of fishing waste and litter to keep waterways clean.</li>
        <li>Follow local and state fishing regulations for a sustainable fishing experience.</li>
        <li>Share knowledge and promote ethical angling practices within the fishing community.</li>
    </ul>
</div>
<?php include 'app/include/footer.php'; ?>

</body>
</html>
