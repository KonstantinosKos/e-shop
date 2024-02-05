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

function createUser($conn, $username, $password, $firstName, $lastName, $email, $phonenumber, $street, $zipcode, $city, $country) {
    $sql = "INSERT INTO users (user_userName, user_password, user_firstName, user_lastName, user_email, user_phoneNumber, user_streetNumber, user_zipCode, user_city, user_state) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: sign-up.php?error=stmtfailed");
        exit();
    }

    $hashedPassword = password_hash($password , PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssssisiss", $username, $hashedPassword, $firstName, $lastName, $email, $phonenumber, $street, $zipcode, $city, $country);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: sign-up.php?error=none");
    exit();
}

function emptyInputLogin($username, $password){
    $result;
    if ( empty($username) || empty($password)){
            $result = true;
    } else {
        $result = false;
    }
    return $result;
}


function loginUser($conn, $username, $password){
    $uidExists = uidExists($conn, $username, $username);

    if ($uidExists === false){
        header("location index.php?error=wronglogin");
        exit();
    }

    $passwordHashed = $uidExists["user_password"];
    $checkPassword = password_verify($password, $passwordHashed);

    if ($checkPassword === false){
        header("location: index.php?error=wronglogin");
        exit();
    } else if ( $checkPassword === true) {
        session_start();
        $_SESSION["userid"] = $uidExists["user_id"];
        $_SESSION["username"] = $uidExists["user_userName"];
        header("location: index.php");
        exit();
    }
}


//product functions

function emptyInputProduct( $productname, $description, $image, $price){
    $result;
    if ( empty($productname) || empty($description) 
        || empty($image) || empty($price)){
            $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function prodIdExists($conn, $productname){
    $sql = "SELECT * FROM products WHERE product_name = ? ;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: add-product.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $productname);
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

function createProd($conn, $productname, $description, $imgContent, $price, $category) {
    $sql_product = "INSERT INTO products (product_name, product_description, product_picture, product_price) VALUES (?, ?, ?, ?)";
    $sql_category = "INSERT INTO categories (product_id, category_name) VALUES (?, ?)";

    $stmt_product = mysqli_stmt_init($conn);
    $stmt_category = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt_product, $sql_product) || !mysqli_stmt_prepare($stmt_category, $sql_category)) {
        header("location: add-product.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt_product, "sssi", $productname, $description, $imgContent, $price);
    mysqli_stmt_execute($stmt_product);
    $productId = mysqli_insert_id($conn); // Get the last inserted product ID

    mysqli_stmt_bind_param($stmt_category, "is", $productId, $category);
    mysqli_stmt_execute($stmt_category);
    mysqli_stmt_close($stmt_category);
    mysqli_stmt_close($stmt_product);

    header("location: add-product.php?error=none");
    exit();
}
?>