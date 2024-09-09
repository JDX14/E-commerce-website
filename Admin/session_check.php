<?php
// session_check.php
session_start();

// Check if the admin session variable is not set or is empty
if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    // Redirect to the login page or any other page as needed
    header("Location: login.php");
    exit;
}
?>