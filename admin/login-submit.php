<?php
require_once('../config.php');

if (isset($_POST["login"])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    // Query the database to check if the provided credentials are valid
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);
   
    if ($result && mysqli_num_rows($result) > 0) {
        // Authentication successful, set session variables and redirect
        $user= mysqli_fetch_assoc($result);
        $_SESSION['username'] = $username;
        $_SESSION['userdata'] = $user;
        $_SESSION['userdata']['login_type'] = $user["type"];
        header('Location: ' . base_url . 'admin/'); // Redirect to home.php upon successful login
        exit();
    } else {
        // Authentication failed, display error message
        $_SESSION['error'] = "Invalid username or password. Please try again.";
        header("Location: login.php");
        exit();
    }
} else {
    // If the request method is not POST, redirect to login page
    header("Location: login.php");
    exit();
}
?>
