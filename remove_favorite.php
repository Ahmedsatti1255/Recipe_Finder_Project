<?php
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $fav_id = intval($_GET['id']);
    $user_id = $_SESSION['user_id'];

    // Delete only user's own favorite
    mysqli_query(
        $conn,
        "DELETE FROM favorites WHERE fav_id = '$fav_id' AND user_id = '$user_id'"
    );
}

header("Location: favorites.php");
exit;
?>
