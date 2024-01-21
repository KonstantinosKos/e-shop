
<?php
include ("config.php");


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Perform a query to get the user with the given email
        $sql = "SELECT * FROM users WHERE user_email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // User found, now check the password
            $row = $result->fetch_assoc();
            $hashedPasswordFromDatabase = $row["user_password"]; // Replace "password" with your actual database column name
        
            // Verify the password
            if ($password == $hashedPasswordFromDatabase) {
                // Successful login
                session_start();
                $_SESSION['logged_in'] = true;
    
                // Redirect to the main page
                header("Location: index.php");
                exit();
            } else {
                // Invalid password
                echo "Invalid email or password. Please try again.";
            }
        } else {
            // User not found
            echo "User not found. Please register or check your credentials.";
        }
    }


?>
