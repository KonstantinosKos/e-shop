<?php 

    include("config.php");
    include("functions.php");
    if (isset($_POST["submit"])){

        $username = $_POST["username"];
        $password = $_POST["password"];

        if ( emptyInputLogin($username, $password) !== false){
            header("location: index.php?error=emptyinput");
            exit();
        }

        loginUser($conn, $username, $password);
    
    } else {
        header("location: index.php");
        exit();
    }

?>