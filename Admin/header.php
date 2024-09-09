<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Supply Guy</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@500;600&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="admin.css">
</head>

<body>
    <!-- HEADER -->
    <header>
        <div class="container">
            <div class="navbar">
                <a class="logo" href="../index.php">
                    <img src="../Logo/MSG Pic.jpeg" alt="My Supply Guy logo"> My Supply Guy
                </a>
                <ul>
                    <li><a href="logout.php?logout=1">Signout</a></li>
                </ul>
            </div>
        </div>
    </header>