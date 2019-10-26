<?php
require("secure/settings.php");
session_start();

$username = $_POST["username"];
$password = $_POST["password"];

if($username == $correct_username){
    if(password_verify($password, $correct_password)){
        $_SESSION["login"] = true;
        header("location:main.html");    
        die();
    }
}

//$hash = password_hash($password, PASSWORD_DEFAULT);
//echo("$hash");
header("location:index.html"); 


?>
