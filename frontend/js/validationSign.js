/**
 * @file This file contains client-side form validation functions.
 * @brief Provides validation for username, email, and password inputs.
 */

/**
 * @brief Get references to HTML elements.
 */
var usernameInput = document.getElementById('username');
var usernameError = document.getElementById('username-error');
var emailInput = document.getElementById('email');
var emailError = document.getElementById('email-error');
var passwordInput = document.getElementById('password');
var passwordError = document.getElementById('password-error');
var confirmPassInput = document.getElementById('password-confirm');
var confirmPassError = document.getElementById('password-repeat-error');
var submitForm = document.getElementById('register-form');
var submitError = document.getElementById('submit-error');

/**
 * @brief Add event listeners for input validation.
 */
emailInput.addEventListener('input', validateEmail);
usernameInput.addEventListener('input', validateName);
passwordInput.addEventListener('input', validatePassword);
confirmPassInput.addEventListener('input', validateConfirmPass);
submitForm.addEventListener('submit', function (event) {
	if (!validateForm()) {
		event.preventDefault();
	}
});

/**
 * @brief Validate email input.
 * @return {boolean} Returns true if email is valid, false otherwise.
 */
function validateEmail() {
	var email = emailInput.value;

	// Check if email is empty
	if (email.length == 0) {
		emailError.innerHTML = "Email is required!";
		return false;
	}

	// Check if email follows the correct format
	if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
		emailError.innerHTML = "Email is invalid!";
		return false;
	}

	// Check if the email already exists using AJAX
	let xml = new XMLHttpRequest();
	xml.open("GET", "frontend/ajax-validation/ajax.php?email=" + encodeURIComponent(email), true);
	xml.onreadystatechange = function () {
		if (xml.readyState === 4) {
			if (xml.status === 200) {
				if (xml.responseText === "invalid") {
					emailError.innerHTML = "Email already exists!";
					return false;
				}
			}
		}
	};
	xml.send();

	emailError.innerHTML = '<i class="gg-check"></i>';
	return true;
}

/**
 * @brief Validate username input.
 * @return {boolean} Returns true if username is valid, false otherwise.
 */
function validateName() {
	var username = usernameInput.value;

	// Check if username is empty
	if (username.length == 0) {
		usernameError.innerHTML = "Username is required!"
		return false;
	}

	if (username.length > 10) {
		usernameError.innerHTML = "Username should be 10 or less!"
		return false;
	}

	if (username.length < 4) {
		usernameError.innerHTML = "Username should be 4 or longer!"
		return false;
	}

	// Check if the username already exists using AJAX
	let xml = new XMLHttpRequest();
	xml.open("GET", "frontend/ajax-validation/ajax.php?username=" + encodeURIComponent(username), true);
	xml.onreadystatechange = function () {
		if (xml.readyState === 4) {
			if (xml.status === 200) {
				if (xml.responseText === "invalid") {
					usernameError.innerHTML = "Username already exists!";
					return false;
				}
			}
		}
	};
	xml.send();

	var usernameRegex = /^[a-zA-Z0-9._-]+$/;

	// Check if the username follows the correct format
	if (!username.match(usernameRegex)) {
		usernameError.innerHTML = "Invalid username format!";
		return false;
	}

	usernameError.innerHTML = '<i class="gg-check"></i>';
	return true;
}

/**
 * @brief Validate password input.
 * @return {boolean} Returns true if password is valid, false otherwise.
 */
function validatePassword() {
	var password = passwordInput.value;

	// Check if password length is less than 6 or greater than or equal to 20
	if (password.length < 6) {
		passwordError.innerHTML = "Length must be 6 or longer!";
		validateConfirmPass();
		return false;
	}
	if (password.length >= 20) {
		passwordError.innerHTML = "Length must be less than 20!";
		validateConfirmPass();
		return false;
	}

	passwordError.innerHTML = '<i class="gg-check"></i>';
	validateConfirmPass();
	return true;
}

/**
 * @brief Validate password confirmation.
 * @return {boolean} Returns true if password confirmation is valid, false otherwise.
 */
function validateConfirmPass() {
	var confirmPass = confirmPassInput.value;

	// Check if passwords match
	if (passwordInput.value.length > 0 && confirmPass !== passwordInput.value) {
		confirmPassError.innerHTML = "Passwords don't match!";
		return false;
	}

	confirmPassError.innerHTML = '<i class="gg-check"></i>';
	return true;
}

/**
 * @brief Validate the entire form.
 * @return {boolean} Returns true if the form is valid, false otherwise.
 */
function validateForm() {
	if (!validateName() || !validateEmail() || !validatePassword() || !validateConfirmPass()) {
		submitError.innerHTML = "Fix the errors!";
		return false;
	}
	return true;
}
