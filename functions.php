<?php
include ("config.php");

function emptyInputSignup($lastname, $firstname, $email, $username, $password){
    $result;
    if (empty($lastname) || empty($firstname) || empty($email) 
        || empty($username) || empty($password)){
            $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidUid($username){
    $result;
    if ( preg_match("/^[a-zA-Z0-9]*$/", $username )) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidUsername($email){
    $result;
    if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function uidExists($conn, $username, $email){
    $sql = "SELECT * FROM users WHERE user_userName = ? OR user_email = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: sign-up.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    mysqli_stmt_close($stmt); 

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    } else {
        $result = false;
        return $result;
    }
}

function createUser($conn, $username, $password, $email, $firstName, $lastName, $phone, $address, $zip, $city, $country) {
    $sql = "INSERT INTO users (user_userName, user_password, user_firstName, user_lastName, user_email, user_phoneNumber, user_streetNumber, user_zipCode, user_city, user_state) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: sign-up.php?error=stmtfailed");
        exit();
    }

    $hashedPassword = password_hash($password , PASSWORD_DEFAULT);

    // mysqli_stmt_bind_param($stmt, "sssssisiss", $username, $password, $firstName, $lastName, $phoneNumber, $street, $zipcode, $city, $state);
    mysqli_stmt_bind_param($stmt, "sssssisiss", $username, $hashedPassword, $firstName, $lastName, $email, $phoneNumber, $street, $zipcode, $city, $state);


    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: sign-up.php?error=none");
    exit();
}



?>