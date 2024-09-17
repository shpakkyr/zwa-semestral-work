<?php
    require 'app/database/db.php';
    require "app/controllers/user.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sign up</title>
    <link rel="icon" type="image/x-icon" href="frontend/img/black.png">
    <link rel="stylesheet" href="frontend/css/header-footer.css">
	<link rel="stylesheet" href="frontend/css/login.css">
</head>
<body>
    <?php include "app/include/header.php"; ?>
	<div class="background"></div>
    <div class="container">
	<div class="container-signup">
			<form action="signup.php" method="POST" id="register-form">
				<h2>Sign up</h2>
                <span id="fields-error"><?=$errMsg?></span>
				<div class="email-class">
					<label for="email">Email:</label>
					<input type="email" id="email" name="email" value="<?=htmlspecialchars($email);?>" placeholder="Enter your email">
					<span id="email-error"><?=$emailErr?></span>
				</div>
				<div class="username-class">
					<label for="username">Username:</label>
					<input type="text" id="username" name="username" value="<?=htmlspecialchars($username);?>" placeholder="Enter your username">
					<span id="username-error"><?=$usernameErr?></span>
				</div>
				<div class="first-password-class">
					<label for="password">Password:</label>
					<input type="password" id="password" name="password" placeholder="Create password">
					<span class="pass-icon" id="pass-icon2"><img src="frontend/img/eye.png" alt=""></span>
					<span id="password-error"><?=$passErr?></span>
				</div>
				<div class="second-password-class">
					<label for="password-confirm">Password:</label>
					<input type="password" id="password-confirm" name="password-confirm" placeholder="Confirm password">
					<span class="pass-icon" id="pass-icon"><img src="frontend/img/eye.png" alt=""></span>
					<span id="password-repeat-error"><?=$confirmErr?></span>
				</div>
				<button id="button-submit" type="submit" name="button-submit">Signup</button>
                <span id="submit-error"><?=$subErr?></span>
				<p>Already have an account? <a href="login.php">Login</a></p>
			</form>
	</div>
    </div>
    <?php include("app/include/footer.php"); ?>

    <script src="frontend/js/signup.js"></script>
	<script src="frontend/js/validationSign.js"></script>
</body>
</html>