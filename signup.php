<?php
include("config.php");
include("functions.php");

if (isset($_POST["submit"])){
    
    $username = $_POST["uid"];
    $password = $_POST["password"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $phonenumber= $_POST["phonenumber"];
    $street = $_POST["street"];
    $zipcode = $_POST["zipcode"];
    $city = $_POST["city"];
    $state = $_POST["state"];

    
    if ( emptyInputSignup($lastname, $firstname, $email, $username, $password) !== false){
        header("location: sign-up.php?error=emptyinput");
        exit();
    }

    // if (invalidUid($username) !== false){
    //     header("location: sign-up.php?error=invaliduid");
    //     exit();
    // }

    if (invalidUsername($email) !== false) 
    {
        header ("location: sign-up.php?error=invalidemail");
        exit();
    }

    if (uidExists($conn, $username, $email)){
        haeder("location: sign-up.php?error=usernametaken");
        exit();
    }

    createUser($conn, $username, $password, $firstname, $lastname, $email, $phonenumber, 
                    $street, $zipcode, $city, $state);
} else {

    header("location: sign-up.php");

}

?>