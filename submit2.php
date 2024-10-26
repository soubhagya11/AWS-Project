<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// MySQL server configuration
$servername = "capstone.ca4onvkpp7qs.ap-south-1.rds.amazonaws.com";
$username = "webappuser";
$password = "Password1234";
$dbname = "webapp";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the username entered by the user
$userInput = isset($_POST['Name']) ? $_POST['Name'] : null;

if ($userInput) {
    // Prepare the SQL statement to check username validity
    $stmt = $conn->prepare("SELECT * FROM customers WHERE Name = ?");
    if ($stmt) {
        $stmt->bind_param("s", $userInput);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the username exists
        if ($result->num_rows > 0) {
            include 'thankyou.html';
        } else {
            echo "Username is invalid.";
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "Please provide a username.";
}

// Close the connection
$conn->close();
?>
