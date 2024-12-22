<?php
session_start();

// Check if user is logged in, retrieve advocate information from database
// Replace this with your actual database retrieval logic
$advocateInfo = array(
    'username' => 'username',
    'email' => 'advocate_email@example.com',
    'contact_info' => 'advocate_contact_info',
    'location' => 'advocate_location',
    'budget' => 'advocate_budget',
    'profile_description' => 'advocate_profile_description'
);

// Return advocate information as JSON
header('Content-Type: application/json');
echo json_encode($advocateInfo);
?>
