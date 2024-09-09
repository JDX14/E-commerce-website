<?php
session_start(); // Start the session if it's not already started

// Check if the user is logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    $response = array('isLoggedIn' => true);
} else {
    $response = array('isLoggedIn' => false);
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>