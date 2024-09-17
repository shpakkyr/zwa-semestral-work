/**
 * @file This file contains client-side validation functions for a login form.
 * @brief Provides validation for the username input and overall form submission.
 */

/**
 * @var {HTMLElement} usernameInput - The input field for the username.
 * @var {HTMLElement} usernameError - The element to display username validation errors.
 * @var {HTMLElement} submitForm - The form submission button.
 * @var {HTMLElement} submitError - The element to display overall form validation errors.
 */
var usernameInput = document.getElementById('username');
var usernameError = document.getElementById('user-error');
var submitForm = document.getElementById('button-login');
var submitError = document.getElementById('fields-error');

/**
 * @brief Add event listeners for input validation and form submission.
 */
usernameInput.addEventListener('input', validateName);
submitForm.addEventListener('submit', function (event) {
    if (!validateForm()) {
        event.preventDefault();
    }
});

/**
 * @brief Validate the entered username.
 * @return {boolean} Returns true if the username is valid, false otherwise.
 */
function validateName() {
    var username = usernameInput.value;

    // Check if username is empty
    if (username.length == 0) {
        usernameError.innerHTML = "Username is required!";
        return false;
    }

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
 * @brief Validate the entire form.
 * @return {boolean} Returns true if the form is valid, false otherwise.
 */
function validateForm() {
    if (!validateName()) {
        submitError.innerHTML = "Fix the errors!";
        return false;
    }
    return true;
}
