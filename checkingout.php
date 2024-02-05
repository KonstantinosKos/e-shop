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

    if (prodIdExists($conn, $productname)){
        header("location: add-product.php?error=productnametaken");
        exit();
    }

    createProd($conn,  $productname, $description, $imgContent, $price, $category);
} else {

    header("location: add-product.php");

}

?>


<?php
    include ("config.php");
    $sql = "SELECT user_userName, user_email, user_phoneNumber   from users";
    $result = $conn -> query($sql);

    if ($result -> num_rows > 0){
        echo '<div style="display: flex; flex-wrap: wrap; justify-content: space-between;  margin-left:8%; margin-top:3%;">';
        while ($row = $result->fetch_assoc()) {
            echo '<div style="flex-basis: calc(33.33% ); margin-bottom: 20px;">
                    <div class="card" style="width: 400px;">
                        <div class="card-body">
                            <h5 class="card-title">Username: ' . $row["user_userName"] .'</h5>
                            <p class="card-text">E-mail: ' . $row["user_email"] .'</p>
                            <p class="card-text">Phone Number: ' . $row["user_phoneNumber"] .'</p>
                            <a href="#" class="btn btn-primary">See Profile</a>
                        </div>
                    </div>
                </div>';
        }
        echo '</div>'; // Close the card-container
    } else {
        echo "no results";
    }

?>