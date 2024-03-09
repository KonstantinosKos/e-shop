<?php
include("config.php");

if(isset($_POST['productId'])) {
    $product_id = $_POST['productId'];

    $sql_delete = "DELETE FROM cart WHERE product_id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $product_id);
    $stmt_delete->execute();

    $stmt_delete->close();

    $conn->close();

    http_response_code(200);
} else {
    http_response_code(400);
}
?>
