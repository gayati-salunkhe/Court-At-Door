<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contact_info = $_POST['contact_info'];
    $password = $_POST['password'];
    $location = $_POST['location'];
    $budget = $_POST['budget'];
    $profile_description = $_POST['profile_description'];
    $user_type = $_POST['user_type'];

    // Handle file upload
    $firm_image = ''; // initialize
    if ($_FILES['firm_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $firm_image = $uploadDir . basename($_FILES['firm_image']['name']);
        move_uploaded_file($_FILES['firm_image']['tmp_name'], $firm_image);
    }

    // Insert data into the appropriate table
    if ($user_type === 'Advocate') {
        $sql = "INSERT INTO advocate (username, email, contact_info, password, firm_image, location, budget, profile_description)
                VALUES ('$username', '$email', '$contact_info', '$password', '$firm_image', '$location', $budget, '$profile_description')";
    } else {
        $sql = "INSERT INTO user (username, email, contact_info, password, location, budget, profile_description)
                VALUES ('$username', '$email', '$contact_info', '$password', '$location', $budget, '$profile_description')";
    }

    if ($conn->query($sql) === TRUE) {
        // Retrieve the user ID of the newly registered user
        $user_id = $conn->insert_id;

        // Start the session and set user ID
        session_start();
        $_SESSION['user_id'] = $user_id;

        // Redirect to user profile page
        header('Location: user_profile.php');
        exit; // Ensure that subsequent code is not executed after redirection
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
