<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT id, username, password FROM user WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["username"] = $username;
            header("Location: house.html");
        } else {
            
        echo "<script>alert('Invalid username or password. Please try again.'); window.location.href ='login.html';</script>";
            
        }
    } else {
        echo "<script>alert('Invalid username or password. Please try again.'); window.location.href ='login.html';</script>";
        
    }
}

$conn->close();
?>
