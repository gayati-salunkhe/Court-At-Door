<?php
include 'db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <!-- Link to your CSS file -->
    <link rel="stylesheet" type="text/css" href="search_results.css">
</head>
<body>
    <div class="container">
        <h2>Resulted Lawyers</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            // Retrieve search parameters
            $location = $_GET['location'];
            $budget_from = $_GET['budget_from'];
            $budget_to = $_GET['budget_to'];

            // Prepare and execute SQL query
            $query = "SELECT * FROM advocate WHERE location = ? AND budget >= ? AND budget <= ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sii", $location, $budget_from, $budget_to); // "s" indicates string type, "i" indicates integer type
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Display search results
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='result'>";
                    echo "Name: " . $row["username"] . "<br>"; // Update "name" to match your database column name
                    echo "Phone: " . $row["contact_info"] . "<br>"; // Assuming "phone_number" is the column name for phone number
                    echo "Location: " . $row["location"] . "<br>";
                    echo "Budget: " . $row["budget"] . "<br>";
                    echo "<hr>";
                    echo "</div>";
                }
            } else {
                echo "<div class='no-results'>No lawyers found matching the criteria.</div>";
            }

            $stmt->close();
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
