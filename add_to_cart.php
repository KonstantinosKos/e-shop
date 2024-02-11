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

    // Check if the user exists
    if ($result_user->num_rows > 0) {
        // Fetch user ID
        $row_user = $result_user->fetch_assoc();
        $user_id = $row_user['user_id'];
        $stmt_select_user->close();

        // Retrieve product ID from the form
        $product_id = $_POST['product_id'];
        $product_price = $_POST["product_price"];
        // // Prepare and execute a query to select product information
        // $sql_select_product = "SELECT product_name, product_price FROM products WHERE product_id = ?";
        // $stmt_select_product = $conn->prepare($sql_select_product);
        // $stmt_select_product->bind_param("i", $product_id);
        // $stmt_select_product->execute();
        // $result_product = $stmt_select_product->get_result();

        // // Check if the product exists
        // if ($result_product->num_rows > 0) {
        //     // Fetch product data
        //     $row_product = $result_product->fetch_assoc();
        //     $product_name = $row_product['product_name'];
        //     $product_price = $row_product['product_price'];
        //     $stmt_select_product->close();

            // Insert the product into the cart table
            $sql_insert = "INSERT INTO cart (user_id, product_id, quantity, price) VALUES (?, ?, 1, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("iii", $user_id, $product_id, $product_price);
            $stmt_insert->execute();
            $stmt_insert->close();

            // Redirect the user to the cart page after successful insertion
            header("location: cart.php");
            exit();
        // } else {
        //     echo "Product not found.";
        // }
    } else {
        echo "User not found.";
    }
} else {
    echo "Please log in to add products to your cart.";
}
?>
