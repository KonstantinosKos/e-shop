<?php

// Include the database connection configuration
include("config.php");

session_start();
$isLoggedIin = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

if ($isLoggedIn) {
        <div class="dropdown">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                Welcome, User!
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Profile</a>
                <a class="dropdown-item" href="#">Settings</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
        </div>
} else {
   
        <form action="login.php" method="post">
            <label for="email">Email:</label>
            <input type="text" name="email" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Login</button>
        </form>
}
?>
