<?php

include("config.php");


if (isset($_POST['productId']) && isset($_POST['newQuantity'])) {
    $productId = $_POST['productId'];
    $newQuantity = $_POST['newQuantity'];


    $sql = "UPDATE cart SET quantity = ? WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $newQuantity, $productId);
    $stmt->execute();
    $stmt->close();

    echo "Quantity updated successfully.";
} else {

    echo "Error: Product ID or new quantity not provided.";
}
?>
