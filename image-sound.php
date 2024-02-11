<?php
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>E-Shop</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="path/to/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body style="background-color: rgb(216, 216, 216);;">
    <div>
        <div>
            <nav class="navbar navbar-expand-lg navbar-light" id="navigation">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php" style="margin-left: 10%; color: rgb(255, 255, 255);">E-Shop</a>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                        <?php 
                                if ($_SESSION["username"] == 'admin') {   
                                    echo 
                                    '<li class="nav-item">
                                        <a class="nav-link" href="adduserproduct.php" style="color: white;">Add User/Product</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="showuserproduct.php" style="color: white;">Show User/Product</a>
                                    </li>';
                                } else { 
                                    echo '             
                                    <li class="nav-item">
                                        <a class="nav-link" href="my-profile.php" style="color: white;">My Profile</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="contact-us.php" style="color: white;">Contact us</a>
                                    </li>';
                                }
                            ?>
                        </ul>
                    </div>
                </div>
                <form class="d-flex">
                    <input class="form-control me-2" type="text" placeholder="Search" id="searchInput">
                    <button class="btn btn-primary" type="button" id="searchButton">Search</button>
                </form>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        // Get the input element, button, and results container
                        var searchInput = document.getElementById('searchInput');
                        var searchButton = document.getElementById('searchButton');

                        // Event listener for button click
                        searchButton.addEventListener('click', function () {
                            // Call the search function with the current input value
                            search(searchInput.value);
                        });

                        // Function to perform the search
                        function search(query) {
                            // test that it works.
                            window.alert('Search query: ' + query);
                        }
                    });
                </script>
                <?php
                    if (isset($_SESSION["username"])){
                        echo ' 
                        <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="margin-right: 98px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
                                 <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                                 <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
                                </svg>
                                Settings
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end"><li><a class="dropdown-item" href="my-profile.php">My Profile</a></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        
                        </ul>
                      </div>';
                    } else {
                        echo '
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal" style="width: 10%;"
                            id="login">
                                Login / Sign-up
                        </button>';
                    }
                ?>

                <!-- Login Modal -->
                <div class="modal" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="container mt-3">
                                <form action="loginform.php" method="POST">
                                    <div class="mb-3 mt-3">
                                        <label for="email">Email:</label>
                                        <input type="text" class="form-control" id="email" placeholder="Enter email"
                                            name="username">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pwd">Password:</label>
                                        <input type="password" class="form-control" id="pwd"
                                            placeholder="Enter password" name="password">
                                    </div>
                                    <div class="form-check mb-3">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" name="remember"> Remember me
                                        </label>
                                    </div>
                                    <div style="display: flex;">
                                        <button type="submit" class="btn btn-primary" id="submit" name="submit">Submit</button>
                                        <a href="sign-up.php" class="btn btn-success"
                                            style="height: 20%; margin-left: 2%;">Sign-up</a>
                                    </div>
                                </form>
                            </div>
                            <?php 
                                if (isset($_GET["error"])){
                                    if ($_GET["error"] == "emptyinput"){
                                        echo "<p> Fill in all fields!";
                                    } else if ($_GET["error"] == "wronglogin"){
                                        echo "<p> incorrect login information!";
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <div id="products-container" onmouseover="showCategories()" onmouseout="hideCategories()">
            <svg xmlns="http://www.w3.org/2000/svg" style=" margin-left: 4%" width="16" height="16" fill="currentColor"
                class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                <path
                    d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
            </svg> <b>Products</b>
            <!-- Dropdown content -->
            <div id="categories-dropdown">
                <a href="pc-laptops.php" class="category"><svg xmlns="http://www.w3.org/2000/svg"
                        style=" margin-right: 5%;" width="16" height="16" fill="currentColor" class="bi bi-pc-display"
                        viewBox="0 0 16 16">
                        <path
                            d="M8 1a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1zm1 13.5a.5.5 0 1 0 1 0 .5.5 0 0 0-1 0m2 0a.5.5 0 1 0 1 0 .5.5 0 0 0-1 0M9.5 1a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zM9 3.5a.5.5 0 0 0 .5.5h5a.5.5 0 0 0 0-1h-5a.5.5 0 0 0-.5.5M1.5 2A1.5 1.5 0 0 0 0 3.5v7A1.5 1.5 0 0 0 1.5 12H6v2h-.5a.5.5 0 0 0 0 1H7v-4H1.5a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .5-.5H7V2z" />
                    </svg>Pc & Laptops</a>
                <a href="gaming.php" class="category"><svg xmlns="http://www.w3.org/2000/svg"
                        style=" margin-right: 5%;" width="16" height="16" fill="currentColor" class="bi bi-controller"
                        viewBox="0 0 16 16">
                        <path
                            d="M11.5 6.027a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m2.5-.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m-6.5-3h1v1h1v1h-1v1h-1v-1h-1v-1h1v-1" />
                        <path
                            d="M3.051 3.26a.5.5 0 0 1 .354-.613l1.932-.518a.5.5 0 0 1 .62.39c.655-.079 1.35-.117 2.043-.117.72 0 1.443.041 2.12.126a.5.5 0 0 1 .622-.399l1.932.518a.5.5 0 0 1 .306.729c.14.09.266.19.373.297.408.408.78 1.05 1.095 1.772.32.733.599 1.591.805 2.466.206.875.34 1.78.364 2.606.024.816-.059 1.602-.328 2.21a1.42 1.42 0 0 1-1.445.83c-.636-.067-1.115-.394-1.513-.773-.245-.232-.496-.526-.739-.808-.126-.148-.25-.292-.368-.423-.728-.804-1.597-1.527-3.224-1.527-1.627 0-2.496.723-3.224 1.527-.119.131-.242.275-.368.423-.243.282-.494.575-.739.808-.398.38-.877.706-1.513.773a1.42 1.42 0 0 1-1.445-.83c-.27-.608-.352-1.395-.329-2.21.024-.826.16-1.73.365-2.606.206-.875.486-1.733.805-2.466.315-.722.687-1.364 1.094-1.772a2.34 2.34 0 0 1 .433-.335.504.504 0 0 1-.028-.079zm2.036.412c-.877.185-1.469.443-1.733.708-.276.276-.587.783-.885 1.465a13.748 13.748 0 0 0-.748 2.295 12.351 12.351 0 0 0-.339 2.406c-.022.755.062 1.368.243 1.776a.42.42 0 0 0 .426.24c.327-.034.61-.199.929-.502.212-.202.4-.423.615-.674.133-.156.276-.323.44-.504C4.861 9.969 5.978 9.027 8 9.027s3.139.942 3.965 1.855c.164.181.307.348.44.504.214.251.403.472.615.674.318.303.601.468.929.503a.42.42 0 0 0 .426-.241c.18-.408.265-1.02.243-1.776a12.354 12.354 0 0 0-.339-2.406 13.753 13.753 0 0 0-.748-2.295c-.298-.682-.61-1.19-.885-1.465-.264-.265-.856-.523-1.733-.708-.85-.179-1.877-.27-2.913-.27-1.036 0-2.063.091-2.913.27z" />
                    </svg> Gaming</a>
                <a href="mobile-tablets.php" class="category"><svg xmlns="http://www.w3.org/2000/svg"
                        style=" margin-right: 5%;" width="16" height="16" fill="currentColor" class="bi bi-tablet"
                        viewBox="0 0 16 16">
                        <path
                            d="M12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                        <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                    </svg>Mobile & Tablets</a>
                <a href="image-sound.php" class="category"><svg xmlns="http://www.w3.org/2000/svg"
                        style=" margin-right: 5%;" width="16" height="16" fill="currentColor" class="bi bi-tv"
                        viewBox="0 0 16 16">
                        <path
                            d="M2.5 13.5A.5.5 0 0 1 3 13h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5M13.991 3l.024.001a1.46 1.46 0 0 1 .538.143.757.757 0 0 1 .302.254c.067.1.145.277.145.602v5.991l-.001.024a1.464 1.464 0 0 1-.143.538.758.758 0 0 1-.254.302c-.1.067-.277.145-.602.145H2.009l-.024-.001a1.464 1.464 0 0 1-.538-.143.758.758 0 0 1-.302-.254C1.078 10.502 1 10.325 1 10V4.009l.001-.024a1.46 1.46 0 0 1 .143-.538.758.758 0 0 1 .254-.302C1.498 3.078 1.675 3 2 3zM14 2H2C0 2 0 4 0 4v6c0 2 2 2 2 2h12c2 0 2-2 2-2V4c0-2-2-2-2-2" />
                    </svg>Image & Sound</a>
                <a href="hardware.php" class="category"><svg xmlns="http://www.w3.org/2000/svg"
                        style=" margin-right: 5%;" width="16" height="16" fill="currentColor" class="bi bi-gpu-card"
                        viewBox="0 0 16 16">
                        <path
                            d="M4 8a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0m7.5-1.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3" />
                        <path
                            d="M0 1.5A.5.5 0 0 1 .5 1h1a.5.5 0 0 1 .5.5V4h13.5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5H2v2.5a.5.5 0 0 1-1 0V2H.5a.5.5 0 0 1-.5-.5m5.5 4a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M9 8a2.5 2.5 0 1 0 5 0 2.5 2.5 0 0 0-5 0" />
                        <path
                            d="M3 12.5h3.5v1a.5.5 0 0 1-.5.5H3.5a.5.5 0 0 1-.5-.5zm4 1v-1h4v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5" />
                    </svg>Hardware</a>
                <a href="printers.php" class="category"> <svg xmlns="http://www.w3.org/2000/svg"
                        style=" margin-right: 5%;" width="16" height="16" fill="currentColor" class="bi bi-printer"
                        viewBox="0 0 16 16">
                        <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1" />
                        <path
                            d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1" />
                    </svg>Printers</a>

                <!-- Add more categories as needed -->
            </div>
        </div>
        <script>
            // JavaScript to show/hide the dropdown on hover
            function showCategories() {
                document.getElementById("categories-dropdown").style.display = "block";
            }

            function hideCategories() {
                document.getElementById("categories-dropdown").style.display = "none";
            }
        </script>
        
        <?php
        include("config.php");

        if (isset($_SESSION["username"])) {
        
            $sql = "SELECT p.product_id, p.product_name, p.product_description, p.product_picture, p.product_price 
                    FROM products p
                    INNER JOIN categories c ON p.category_id = c.category_id
                    WHERE category_name = 'imagesound'";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<div style="display: flex; flex-wrap: wrap; justify-content: space-between;  margin-left:8%; margin-top:3%;">';
                while ($row = $result->fetch_assoc()) {
                    echo '<div style="flex-basis: calc(33.33% ); margin-bottom: 20px;">
                            <div class="card" style=width:50%;>
                                <div class="card-body">
                                    <h5 class="card-title"> ' . $row["product_name"] .'</h5>
                                    <img class="card-img-top" src="data:image/jpeg;base64,'.base64_encode($row["product_picture"]).'" style="width:50%; height: 50%;">
                                    <p class="card-text">Description: ' . $row["product_description"] .' </p>
                                    <p class="card-text">Price: €' . $row["product_price"] .' </p>
                                    <form action="add_to_cart.php" method="POST">
                                        <input type="hidden" name="username" value="' .$_SESSION["username"] . '">
                                        <input type="hidden" name="user_id" value="' . $_SESSION["user_id"] . '">
                                        <input type="hidden" name="product_id" value="' . $row["product_id"] . '">
                                        <input type="hidden" name="product_price" value="' . $row["product_price"] . '">

                                        <button type="submit" name="submit" class="btn btn-primary" style="width:50%; margin-left:20%;">Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>';
                }
                echo '</div>'; // Close the card-container
            } else {
                echo "No results";
            }
        } else {
            echo "Please log in to view products.";
        }
        ?>



    </div>
    <footer>
        <small>
            &copy; 2023 E-Shop. All rights reserved.
        </small>
    </footer>
</body>

</html>