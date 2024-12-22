<?php
session_start();
// Include database connection
include 'db_connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $password = $_POST["password"];
    $user_type = $_POST["user_type"]; // Get the selected user type

    // Query the database to check if username and password match
    $sql = "SELECT * FROM $user_type WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Start session and store user ID and user type
        $_SESSION['user_id'] = $result->fetch_assoc()['id'];
        $_SESSION['user_type'] = $user_type;

        // Redirect to profile page based on user type
        if ($user_type == "advocate") {
            header("Location: advocate_profile.php");
        } else {
            header("Location: user_profile.php");
        }
        exit;
    } else {
        // Redirect back to login page with error message
        header("Location: login.html?error=1");
        exit;
    }
}

// Close database connection
$conn->close();
?>
