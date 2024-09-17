<?php
require "../../app/database/db.php";

global $connection;
echo check();

/**
 * <p>Function returns string valid or invalid depending if user or email already exists or not</p>
 */
function check(): string
{
    $result = "valid";
    if (!empty($_GET["email"])) {
        $email = $_GET["email"];

        $existence = selectOne('user', ['email' => $email]);
        if($existence['email'] === $email){
            $result = 'invalid';
        }
    }
    elseif (!empty($_GET["username"]))
    {
        $username = $_GET["username"];

        $existence = selectOne('user', ['username' => $username]);
        if($existence['username'] === $username){
            $result = 'invalid';
        }
    }
    return $result;
}