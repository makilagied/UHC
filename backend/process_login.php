<?php
session_start();

require_once('db.php'); // Include the database connection file


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
