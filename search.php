<?php
include("config.php");


if(isset($_POST['query'])) {
    
    $search_query = $_POST['query'];

    $sql = "SELECT * FROM products WHERE product_name LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_query = '%' . $search_query . '%'; 
    $stmt->bind_param("s", $search_query);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            
            echo "<div>{$row['product_name']}</div>";
        }
    } else {
        echo "No results found";
    }
    $stmt->close();
} else {
    echo "No search query provided";
}
$conn->close();
?>
