<?php
function emptyInputSignup($username, $email, $pwd, $pwdrepeat){
    //$result;
    if(empty($username) || empty($email) || empty($pwd) || empty($pwdrepeat)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function invalidUid($username){
    //$result;
    if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function invalidEmail($email){
    //$result;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd, $pwdrepeat){
    //$result;
    if($pwd !== $pwdrepeat){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function uidExists($db, $username, $email){
    $sql = "SELECT * FROM uživatelé WHERE jmeno = ? OR email = ?;";
    $stmt = mysqli_stmt_init($db);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=usernameoremailtaken");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }
    else{
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createUser($db, $username, $email, $pwd){
    $sql = "INSERT INTO uživatelé (jmeno, email, heslo) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($db);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=usernameoremailtaken");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../index.php?error=none");
}


function emptyInputLogin($username, $pwd){
    //$result;
    if(empty($username) || empty($pwd)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function loginUser($db, $username, $pwd){
    $uidExists = uidExists($db, $username, $username);

    if($uidExists === false){
        header("location: ../index.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists["heslo"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if($checkPwd === false){
        header("location: ../index.php?error=wronglogin");
        exit();
    }
    else if($checkPwd === true){
        session_start();
        $_SESSION["id_uzivatele"] = $uidExists["id_uzivatele"];
        $_SESSION["jmeno"] = $uidExists["jmeno"];
        header("location: ../index.php");
        exit();
    }

}