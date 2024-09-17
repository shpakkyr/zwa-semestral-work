<?php
    include "app/database/db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="frontend/css/header-footer.css">
    <link rel="stylesheet" href="frontend/css/welcome.css">
    <link rel="icon" type="image/x-icon" href="frontend/img/black.png">
</head>
<body>
    <?php include("app/include/header.php"); ?>
	<p class="slogan">
		Make yourself stronger<br>than your excuses
	</p>
	<div class="explore"><a href="courses-list.php">Explore more</a></div>

    <?php include("app/include/footer.php"); ?>

</body>
</html>
