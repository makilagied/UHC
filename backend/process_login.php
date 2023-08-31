<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "Bee19Knee's99";
$dbname = "UHC";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get input from the login form
$username = $_POST['username'];
$password = $_POST['password'];

// Validate user input
$username = $conn->real_escape_string($username);

// Check if user exists in the login table
$sql = "SELECT doctor_id, username, password FROM login WHERE username = '$username' LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $storedPassword = $row['password'];

    // Verify the password
    if (password_verify($password, $storedPassword)) {
        // ... rest of the authentication process
        $_SESSION['doctor_id'] = $row['doctor_id'];
        $_SESSION['username'] = $row['username'];
        header("Location: ../dashboard.php"); // Redirect to the dashboard
        exit(); // Ensure the script stops here after redirection
    } else {
        echo "Invalid password";
    }
} else {
    echo "User not found";
}


$conn->close();
?>
