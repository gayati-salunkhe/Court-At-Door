<?php
session_start();

// Check if user is logged in and retrieve user information
if (isset($_SESSION['username'])) {
    // Include database connection
    include 'db_connection.php';

    // Retrieve username from session
    $username = $_SESSION['username'];

    // Prepare SQL statement
    $sql = "SELECT * FROM user WHERE username = ?";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);

    // Execute query
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    // Check if user information is found
    if ($result->num_rows == 1) {
        // Fetch user data
        $userInfo = $result->fetch_assoc();

        // Output user information as JSON
        header('Content-Type: application/json');
        echo json_encode($userInfo);
    } else {
        // Handle error if user information is not found
        header("HTTP/1.1 404 Not Found");
        echo json_encode(array('error' => 'User information not found'));
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Handle error if user is not logged in
    header("HTTP/1.1 401 Unauthorized");
    echo json_encode(array('error' => 'User is not logged in'));
}
?>
