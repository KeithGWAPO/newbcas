<?php
// Connect to MySQL database
$host = "localhost";
$dbname = "bcas";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start(); // Start session for user data storage

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if user exists and retrieve user data
    $stmt = $conn->prepare("SELECT firstname, lastname, role FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['firstname'] = $row['firstname'];
        $_SESSION['lastname'] = $row['lastname'];
        $_SESSION['role'] = $row['role'];

        // Redirect based on user role
        if ($row['role'] === 'admin') {
            header("Location: ../frontend/admin-dashboard.php");
        } elseif ($row['role'] === 'staff') {
            header("Location: ../frontend/staff-home.php");
        }
        exit();
    } else {
        echo "<script>alert('Invalid username or password'); window.location.href = '../frontend/login.html';</script>";
    }
}
?>
