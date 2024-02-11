<?php
include("config.php");
session_start();

include("functions.php");

if (isset($_POST["submit"])){

    $firstname = $_POST["user_firstName"];
    $lastname= $_POST["user_lastName"];
    $email= $_POST["user_email"];
    $address = $_POST["user_streetNumber"];
    $city = $_POST["user_city"];
    $state= $_POST["user_state"];
    $zipcode= $_POST["user_zipCode"]; 
    $credit_cardNumber= $_POST["credit_cardNumber"];
    $credit_cardType = $_POST["credit_cardType"];
    $credit_cardExpiration = $_POST["credit_cardExpiration"];
    $credit_cardName = $_POST["credit_cardName"];
    

    $username = $_SESSION['username'];
    
    $sql_select_user = "SELECT user_id FROM users WHERE user_userName  = ?";
    $stmt_select_user = $conn->prepare($sql_select_user);
    $stmt_select_user->bind_param("s", $username);
    $stmt_select_user->execute();
    $result_user = $stmt_select_user->get_result();
    $row_user = $result_user->fetch_assoc();
    $user_id = $row_user['user_id'];
    $stmt_select_user->close();
    

   
    createOrder($conn, $user_id, $credit_cardType, $credit_cardName, $credit_cardNumber, $credit_cardExpiration);
} else {

    header("location: ordering.php");

}

?>