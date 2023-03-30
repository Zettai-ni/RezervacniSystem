<?php

if(isset($_POST["submit"])){
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];

    include('../db.php');
    require_once 'funkceLogin.php';

    if(emptyInputLogin($username, $pwd) !== false){
        header("location: ../index.php?error=emptyinput");
        exit();
    }

    loginUser($db, $username, $pwd);
}
else{
    header("location: ../index.php");
    exit();
}

