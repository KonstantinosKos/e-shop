<?php
include("config.php");
include("functions.php");

if (isset($_POST["submit"])){
    
    $productname = $_POST["uid"];
    $description= $_POST["description"];
    $price= $_POST["price"];
    $category = $_POST["category"];

    $file = $_FILES["image"]["name"];
    $tempname = $_FILES["image"]["tmp_name"];
    $folder = "uploadimg/".$file;
    move_uploaded_file($tempname, $folder);

    
    if ( emptyInputProduct( $productname, $description, $folder, $price) !== false){
        header("location: add-prodduct.php?error=emptyinput");
        exit();
    }

    if (prodIdExists($conn, $productname, $productid)){
        header("location: add-product.php?error=productnametaken");
        exit();
    }

    createProd($conn,  $productname, $description, $folder, $price, $category);
} else {

    header("location: add-product.php");

}

?>