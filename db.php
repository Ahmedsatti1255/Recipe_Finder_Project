<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "recipe_db");
if (!$conn) {
    die("Database connection failed");
}
?>
