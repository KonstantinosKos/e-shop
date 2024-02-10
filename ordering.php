<?php
include("config.php");
include("functions.php");

if (isset($_POST["submit"])){
    
    $firstname = $_POST["firstname"];
    $lastname= $_POST["lastname"];
    $email= $_POST["email"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $state= $_POST["state"];
    $zipcode= $_POST["zipcode"]; 
    $creditcardid= $_POST["creditcardid"];  

    
    if ( emptyInputOrder( $firstname, $lastname, $email, $address, $city, $state, $zipcode, $creditcardid) !== false){
        header("location: ordering.php?error=emptyinput");
        exit();
    }
    createOrder($conn, $firstname, $lastname, $email, $address, $city, $state, $zipcode, $creditcardid );
} else {

    header("location: ordering.php");

}

?>