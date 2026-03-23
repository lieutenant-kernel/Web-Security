<?php
session_start();

$fixed_username = "blogger";
$fixed_password = "blogger";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $fixed_username && $password === $fixed_password) {
        $_SESSION['loggedin'] = true;
        header("Location: index.php");
    } else {
        echo "Ungültige Anmeldedaten";
    }
}
?>
