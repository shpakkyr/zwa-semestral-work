<?php
session_start();

unset($_SESSION['id_user']);
unset($_SESSION['email']);
unset($_SESSION['username']);
unset($_SESSION['admin']);

header("location: index.php");