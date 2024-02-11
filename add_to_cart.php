<?php
include("config.php");
session_start();

if (isset($_SESSION["username"]) && isset($_POST["submit"])) {
    $username = $_SESSION['username'];
    
    $sql_select_user = "SELECT user_id FROM users WHERE user_userName  = ?";
    $stmt_select_user = $conn->prepare($sql_select_user);
    $stmt_select_user->bind_param("s", $username);
    $stmt_select_user->execute();
    $result_user = $stmt_select_user->get_result();

    if ($result_user->num_rows > 0) {
        $row_user = $result_user->fetch_assoc();
        $user_id = $row_user['user_id'];
        $stmt_select_user->close();

     
        $product_id = $_POST['product_id'];
        $product_price = $_POST["product_price"];
    
            $sql_insert = "INSERT INTO cart (user_id, product_id, quantity, price) VALUES (?, ?, 1, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("iii", $user_id, $product_id, $product_price);
            $stmt_insert->execute();
            $stmt_insert->close();

            header("location: cart.php");
            exit();
     
    } else {
        echo "User not found.";
    }
} else {
    echo "Please log in to add products to your cart.";
}
?>
