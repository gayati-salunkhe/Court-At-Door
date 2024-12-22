<?php
session_start(); // Start the session

// Initialize $userData array
$userData = array(
    "username" => "",
    "email" => "",
    "contact_info" => "",
    "location" => "",
    "budget" => "",
    "profile_description" => ""
);

// Check if user is logged in and session variable is set
if (isset($_SESSION['user_id'])) {
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

    // Prepare and execute SQL query
    $query = "SELECT * FROM user  WHERE id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Error in preparing statement: " . $conn->error);
    }
    $stmt->bind_param("i", $user_id); // "i" indicates integer type
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user data
        $row = $result->fetch_assoc();

        // Store user data in array
        $userData = array(
            "username" => $row["username"],
            "email" => $row["email"],
            "contact_info" => $row["contact_info"],
            "location" => $row["location"],
            "budget" => $row["budget"],
            "profile_description" => $row["profile_description"]
        );
    } else {
      //  echo "No user data found.";
    }


        // Prepare and execute SQL query
        $query = "SELECT * FROM advocate  WHERE id = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die("Error in preparing statement: " . $conn->error);
        }
        $stmt->bind_param("i", $user_id); // "i" indicates integer type
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            // Fetch user data
            $row = $result->fetch_assoc();
    
            // Store user data in array
            $userData = array(
                "username" => $row["username"],
                "email" => $row["email"],
                "contact_info" => $row["contact_info"],
                "location" => $row["location"],
                "budget" => $row["budget"],
                "profile_description" => $row["profile_description"]
            );
        } else {
           // echo "No user data found.";
        }


    $stmt->close();
    $conn->close();
} else {
    // Redirect user to login page if not logged in
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <div class="container">
        <h1>User Profile</h1>
        <div class="profile-info">
            <table>
                <tr>
                    <th>Username:</th>
                    <td><span id="username"><?php echo htmlspecialchars($userData['username']); ?></span></td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td><span id="email"><?php echo htmlspecialchars($userData['email']); ?></span></td>
                </tr>
                <tr>
                    <th>Contact Info:</th>
                    <td><span id="contact_info"><?php echo htmlspecialchars($userData['contact_info']); ?></span></td>
                </tr>
                <tr>
                    <th>Location:</th>
                    <td><span id="location"><?php echo htmlspecialchars($userData['location']); ?></span></td>
                </tr>
                <tr>
                    <th>Budget:</th>
                    <td><span id="budget"><?php echo htmlspecialchars($userData['budget']); ?></span></td>
                </tr>
                <tr>
                    <th>Profile Description:</th>
                    <td><span id="profile_description"><?php echo htmlspecialchars($userData['profile_description']); ?></span></td>
                </tr>
            </table>
            <button onclick="location.href='search_lawyer.html';">Search Lawyers</button>
        </div>
    </div>
</body>
</html>
