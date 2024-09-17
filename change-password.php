<?php
require "app/database/db.php";
require 'app/controllers/user.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Course</title>
    <link rel="stylesheet" href="frontend/css/header-footer.css">
    <link rel="stylesheet" href="frontend/css/change-password.css">
    <link rel="icon" type="image/x-icon" href="frontend/img/black.png">
</head>
<body>
<?php include("app/include/header.php"); ?>

<?php if(isset($_SESSION['admin'])): ?>
<div class="container-create">
    <form action="change-password.php" method="post">
        <span id="fields-error"><?=$errMsg?></span>
        <div class="container-block">
            <label for="old-password">Old password:</label>
            <div class="container-input">
                <input type="password" name="old-password" id="old-password" placeholder="Your old password">
            </div>
        </div>
        <div class="container-block">
            <label for="new-password">New password:</label>
            <div class="container-input">
                <input type="password" name="new-password" id="new-password" placeholder="Your new password">
            </div>
        </div>
        <div class="container-block">
            <label for="repeat-password">Repeat your password:</label>
            <div class="container-input">
                <input type="password" name="repeat-password" id="repeat-password" placeholder="Repeat your password">
            </div>
        </div>
        <div class="container-buttons">
            <button name="change-button" id="change-button" type="submit">Change</button>
            <button name="cancel-button" id="cancel-button">Cancel</button>
        </div>
    </form>
</div>
<?php else: ?>
    <div class="container-empty">
        <h2>You have no access to this page!</h2>
    </div>
<?php endif; ?>

<?php include("app/include/footer.php"); ?>
</body>
</html>
