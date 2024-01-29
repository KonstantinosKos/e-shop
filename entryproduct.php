<?php
include("config.php");
include("functions.php");

if (isset($_POST["submit"])){
    
    $productname = $_POST["uid"];
    $description= $_POST["description"];
    $price= $_POST["price"];
    $category = $_POST["category"];

    $image = $_FILES['image']['tmp_name'];
    $imgContent = file_get_contents($image);

    
    if ( emptyInputProduct( $productname, $description, $imgContent, $price) !== false){
        header("location: add-prodduct.php?error=emptyinput");
        exit();
    }

    if (prodIdExists($conn, $productname, $productid)){
        header("location: add-product.php?error=productnametaken");
        exit();
    }

    createProd($conn,  $productname, $description, $imgContent, $price, $category);
} else {

    header("location: add-product.php");

}

?>