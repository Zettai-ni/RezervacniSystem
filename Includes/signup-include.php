<?php

if(isset($_POST["submit"])){

    $username = $_POST["username"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $pwdrepeat = $_POST["pwdrepeat"];

    include('../db.php');
    require_once 'funkceLogin.php';

    if(emptyInputSignup($username, $email, $pwd, $pwdrepeat) !== false){
        header("location: ../index.php?error=emptyinput");
        exit();
    }

    if(invalidUid($username) !== false){
        header("location: ../index.php?error=invalidUid");
        exit();
    }
    if(invalidEmail($email) !== false){
        header("location: ../index.php?error=invalidEmail");
        exit();
    }
    if(pwdMatch($pwd, $pwdrepeat) !== false){
        header("location: ../index.php?error=invalidPassword");
        exit();
    }
    if(uidExists($db, $username, $email) !== false){
        header("location: ../index.php?error=usernametaken");
        exit();
    }

    createUser($db, $username, $email, $pwd);


}
else{
    header("location: ../index.php");
    exit();
}