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
    // Prepare and execute category insertion
    $sql_category = "INSERT INTO categories (category_name) VALUES (?)";
    $stmt_category = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt_category, $sql_category)) {
        header("location: add-product.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt_category, "s", $category);
    mysqli_stmt_execute($stmt_category);

    // Get the category ID of the newly inserted category
    $categoryId = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt_category);

    // Prepare and execute product insertion
    $sql_product = "INSERT INTO products (product_name, product_description, product_picture, product_price, category_id) VALUES (?, ?, ?, ?, ?)";
    $stmt_product = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt_product, $sql_product)) {
        header("location: add-product.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt_product, "sssii", $productname, $description, $imgContent, $price, $categoryId);
    mysqli_stmt_execute($stmt_product);
    mysqli_stmt_close($stmt_product);

    header("location: add-product.php?error=none");
    exit();
}

?>