<?php

/**
 * Variables for course details.
 */
$email = '';
$username = '';
$errMsg = '';
$emailErr = '';
$usernameErr = '';
$passErr = '';
$confirmErr = '';
$subErr = '';

/**
 * Creation of session after logging in or registration.
 *
 * @var int $_SESSION ['id_user'] User ID.
 * @var string $_SESSION ['email']    User email.
 * @var string $_SESSION ['username'] User username.
 * @var int $_SESSION ['admin']    User role (admin or regular user).
 *
 * @return void
 */
function userAuth($user)
{
    $_SESSION['id_user'] = $user['id_user'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['admin'] = $user['admin'];
    if($_SESSION['admin'] === 0)
    {
        header("location: courses-list.php");

    }
    else
    {
        header("location: index-posts.php");
    }
}

/**
 * Verify and set error messages for user registration data.
 *
 * @param string $username
 * @param string $email
 * @param string $password
 * @param string $passwordConfirm
 */
function verifyData($username, $email, $password, $passwordConfirm) : void
{
    global $emailErr, $usernameErr, $passErr, $confirmErr;

    if($username === '')
    {
        $usernameErr = "Username is required!";
    }
    elseif(strlen($username) < 4)
    {
        $usernameErr = "Username should be 4 or longer!";
    }
    elseif(strlen($username) > 10)
    {
        $usernameErr = "Username should be 10 or less!";
    }
    if($email === '')
    {
        $emailErr = "Email is required!";
    }
    if(strlen($password) >= 20)
    {
        $passErr = "Length must be less than 20!";
    }
    elseif(strlen($password) < 6)
    {
        $passErr = "Length must be 6 or longer!";
    }
    if($password !== $passwordConfirm)
    {
        $confirmErr = "Passwords don't match!";
    }
}


/**
 * <p>Checks if the form with sign up was submitted. If yes and it paths all the validations then create this user.</p>
 */
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-submit']))
{
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $passwordConfirm = trim($_POST['password-confirm']);
    $admin = 0;

    $emailRegex = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';
    $usernameRegex = '/^[a-zA-Z0-9._-]+$/';

    verifyData($username, $email, $password, $passwordConfirm);

    if($username === '' || $email === '' || $password === '' || $passwordConfirm === '')
    {
        $errMsg = "Field mustn't be empty!";
        $subErr = "Fix the errors!";
    }
    elseif(!preg_match($usernameRegex, $username))
    {
        $usernameErr = "Invalid username format!";
    }
    elseif(!preg_match($emailRegex, $email))
    {
        $emailErr = "Invalid email format!";
    }
    elseif ($errMsg === '' && $emailErr === '' && $usernameErr === '' && $passErr === '' && $confirmErr === '' && $subErr === '')
    {
        ob_start();
        $existence = selectOne('user', ['email' => $email]);
        if($existence['email'] === $email)
        {
            ob_end_clean();
            $emailErr = "User with your email already exists!";
        }
        else
        {
            $passwordPush = password_hash($password, PASSWORD_DEFAULT);
            $post = ['admin' => $admin, 'username' => $username, 'email' => $email, 'password' => $passwordPush];
            $id = insert('user', $post);
            $user = selectOne('user', ['id_user' => $id]);
            userAuth($user);
        }
    }
}

/**
 * <p>Checks if the form with log in was submitted. If yes and it paths all the validations then log in user.</p>
 */
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-login']))
{
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $usernameRegex = '/^[a-zA-Z0-9._-]+$/';

    if($username === '' || $password === '')
    {
        $errMsg = "Field mustn't be empty!";
    }
    elseif(!preg_match($usernameRegex, $username))
    {
        $usernameErr = "Invalid username format!";
    }
    else
    {
        $existence = selectOne('user', ['username' => $username]);
        if($existence && password_verify($password, $existence['password']))
        {
            userAuth($existence);
        }
        else
        {
            $errMsg = "Username or password don't match";
        }
    }
}

/**
 * <p>Gets a user detail to fill the form with edit user in admin panel</p>
 */
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']))
{
    $id = $_GET['id'];
    if(is_numeric($id))
    {
        $user = selectOne('user', ['id_user' => $id]);
        if($user)
        {
            $username = $user['username'];
            $email = $user['email'];
        }
    }
}

/**
 * <p>Deletes user via admin panel</p>
 */
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete-id']))
{
    $id = $_GET['delete-id'];
    $user = selectOne('user', ['id_user' => $id]);
    $name = $user['username'];
    delete('user', $id, 'id_user');
//    $errMsg = "Course with name $name was deleted!";
    header("location: index-users.php");
}

/**
 * <p>Redirects an admin to table with users after clicking on cancel button</p>
 */
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel-edit-button']))
{
    header("location: index-users.php");
}

/**
 * <p>Updates user after clicking on edit button in form</p>
 */
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit-edit-button']))
{
    $id = $_POST['id'];
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

    $emailRegex = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';
    $usernameRegex = '/^[a-zA-Z0-9._-]+$/';

    if($username === '')
    {
        $usernameErr = "Username is required!";
    }
    elseif(strlen($username) < 4)
    {
        $usernameErr = "Username should be 4 or longer!";
    }
    elseif(strlen($username) > 10)
    {
        $usernameErr = "Username should be 10 or less!";
    }
    if($email === '')
    {
        $emailErr = "Email is required!";
    }

    if($username === '' || $email === '')
    {
        $errMsg = "Field mustn't be empty!";
    }
    elseif(!preg_match($usernameRegex, $username))
    {
        $usernameErr = "Invalid username format!";
    }
    elseif(!preg_match($emailRegex, $email))
    {
        $emailErr = "Invalid email format!";
    }
    elseif ($errMsg === '' && $emailErr === '' && $usernameErr === '')
    {
        $existence = selectOne('user', ['id_user' => $id]);
        $checkEmail = selectOne('user', ['email' => $email]);
        $checkUsername = selectOne('user', ['username' => $username]);
        if(!$checkEmail || ($checkEmail && $existence && $existence['id_user'] === $checkEmail['id_user']))
        {
            if(!$checkUsername || ($checkUsername && $existence && $existence['id_user'] === $checkUsername['id_user']))
            {
                $user = ['username' => $username, 'email' => $email];
                update('user', $user, $id, 'id_user');
                header("location: index-users.php");
            }
            else
            {
                $usernameErr = "Username is already used by other user!";
            }
        }
        else
        {
            $emailErr = "Email is already used by other user!";
        }
    }
}

/**
 * <p>Redirects a user to list of courses after clicking on cancel button</p>
 */
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel-button']))
{
    header("location: courses-list.php");
}

/**
 * <p>Changes password</p>
 */
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change-button']))
{
    $id = $_SESSION['id_user'];
    $email = trim($_SESSION['email']);
    $username = trim($_SESSION ['username']);
    $admin = $_SESSION['admin'];

    $oldPass = trim($_POST['old-password']);
    $newPass = trim($_POST['new-password']);
    $repeatPass = trim($_POST['repeat-password']);

    if($oldPass === '' || $newPass === '' || $repeatPass === '')
    {
        $errMsg = "Fields mustn't be empty!";
    }
    elseif($newPass !== $repeatPass)
    {
        $errMsg = "New passwords don't match!";
    }
    else
    {
        $user = selectOne('user', ['id_user' => $id]);
        if ($user && password_verify($oldPass, $user['password']))
        {
            $passwordPush = password_hash($newPass, PASSWORD_DEFAULT);
            $user = ['admin' => $admin, 'username' => $username, 'email' => $email, 'password' => $passwordPush];
            update('user', $user, $id, 'id_user');
            header("location: courses-list.php");
        }
        else{
            $errMsg = "Old password doesn't match with your actual!";
        }
    }
}