<?php
require 'app/database/db.php';
require 'app/controllers/user.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin edit</title>
    <link rel="stylesheet" href="frontend/css/header-footer.css">
    <link rel="stylesheet" href="frontend/css/create-course.css">
    <link rel="icon" type="image/x-icon" href="frontend/img/black.png">
</head>
<body>
<?php include("app/include/header.php"); ?>
<?php if(isset($_SESSION['admin']) && $_SESSION['admin'] === 1): ?>
<div class="container-create">
    <form action="edit-users.php" method="post">
        <span class="fields-error"><?=$errMsg?></span>
        <input name="id" type="hidden" value="<?=$id;?>">
        <div class="container-block">
            <label for="username">Username:</label>
            <div class="container-input">
                <input type="text" name="username" id="username" value="<?=htmlspecialchars($username);?>" placeholder="Username">
            </div>
            <span class="fields-error"><?=$usernameErr?></span>
        </div>
        <div class="container-block">
            <label for="email">Email:</label>
            <div class="container-input">
                <input type="text" name="email" id="email" value="<?=htmlspecialchars($email);?>" placeholder="Username">
            </div>
            <span class="fields-error"><?=$emailErr?></span>
        </div>
        <div class="container-buttons">
            <button name="edit-edit-button" id="create-button" type="submit">Edit</button>
            <button name="cancel-edit-button" id="cancel-button">Cancel</button>
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
