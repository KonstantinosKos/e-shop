<?php
include("config.php");
session_start();

// Check if the user is logged in
if (isset($_SESSION["user_id"]) && isset($_POST["submit"])) {
    // Get the user ID from the session
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $sql_select = "SELECT product_name, product_price FROM products WHERE product_id = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("i", $product_id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();

        $row = $result->fetch_assoc();
        $product_name = $row['product_name'];
        $product_price = $row['product_price'];
        $stmt_select->close();

        $sql_insert = "INSERT INTO cart (user_id, product_id, quantity, price) VALUES (?, ?, 1, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("iii", $user_id, $product_id, $product_price);
        $stmt_insert->execute();
        $stmt_insert->close();

        header("location: cart.php");
        exit(); 
    
} else {
    echo "Please log in to add products to your cart.";
}
?>
