<?php
session_start(); // Start the session

// Check if user is logged in and session variables are set
if (!isset($_SESSION['user_id'], $_SESSION['user_type']) || $_SESSION['user_type'] !== 'advocate') {
    echo "User is not logged in as an advocate.";
    exit(); // Exit script if user is not logged in or not an advocate
}

$servername = "localhost";
$username = "root";
$password = "";
$db = "registration_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id']; // Retrieve user ID from session

// Prepare and execute SQL query to fetch advocate data
$query = "SELECT * FROM advocate WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id); // "i" indicates integer type
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Store advocate data in array
    $advocateData = array(
        "username" => $row["username"],
        "email" => $row["email"],
        "contact_info" => $row["contact_info"],
        "location" => $row["location"],
        "budget" => $row["budget"],
        "profile_description" => $row["profile_description"]
    );
} else {
    echo "No advocate data found.";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advocate Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <div class="container">
        <h1>Advocate Profile</h1>
        <div class="profile-info">
            <table>
                <tr>
                    <th>Username:</th>
                    <td><span id="username"><?php echo $advocateData['username']; ?></span></td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td><span id="email"><?php echo $advocateData['email']; ?></span></td>
                </tr>
                <tr>
                    <th>Contact Info:</th>
                    <td><span id="contact_info"><?php echo $advocateData['contact_info']; ?></span></td>
                </tr>
                <tr>
                    <th>Location:</th>
                    <td><span id="location"><?php echo $advocateData['location']; ?></span></td>
                </tr>
                <tr>
                    <th>Budget:</th>
                    <td><span id="budget"><?php echo $advocateData['budget']; ?></span></td>
                </tr>
                <tr>
                    <th>Profile Description:</th>
                    <td><span id="profile_description"><?php echo $advocateData['profile_description']; ?></span></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
