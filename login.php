<?php
    require 'app/database/db.php';
    require "app/controllers/user.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
    <link rel="stylesheet" href="frontend/css/header-footer.css">
	<link rel="stylesheet" href="frontend/css/login.css">
    <link rel="icon" type="image/x-icon" href="frontend/img/black.png">
</head>
<body>
    <?php include "app/include/header.php"; ?>
	<div class="background"></div>
    <div class="container">
	<div class="container-login">
			<form action="login.php" method="POST" id="login-form">
				<h2>Login</h2>
                <span id="fields-error"><?=$errMsg?></span>
				<div class="username-class">
					<label for="username">Username:</label>
					<input type="text" id="username" name="username" placeholder="Enter your username" value="<?=$username?>">
                    <span class="user-error"><?=$usernameErr?></span>
				</div>
				<div class="password-class">
					<label for="password">Password:</label>
					<input type="password" id="password" name="password" placeholder="Enter your password">
					<span class="pass-icon" id="pass-icon"><img src="frontend/img/eye.png" alt=""></span>
                    <span class="user-error"><?=$passErr?></span>
				</div>
				<button type="submit" name="button-login" id="button-login">Login</button>
				<p>Don't have an account? <a href="signup.php">Signup</a></p>
			</form>
	</div>
    </div>
    <?php include("app/include/footer.php"); ?>

    <script src="frontend/js/login.js"></script>
    <script src="frontend/js/validationLogin.js"></script>
</body>
</html>