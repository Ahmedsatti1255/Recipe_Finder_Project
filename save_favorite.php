<?php
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$title = mysqli_real_escape_string($conn, $_GET['title']);
$link = mysqli_real_escape_string($conn, $_GET['link']);
$snippet = mysqli_real_escape_string($conn, $_GET['snippet']);

$user_id = $_SESSION['user_id'];

$sql = "INSERT INTO favorites (user_id, title, link, snippet)
        VALUES ('$user_id', '$title', '$link', '$snippet')";

if (mysqli_query($conn, $sql)) {
    header("Location: favorites.php"); // 🔥 redirect
    exit;
} else {
    echo "Error saving recipe";
}
?>
