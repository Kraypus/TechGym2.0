<?php
session_start();

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/database.php";

    $userId = $_SESSION["user_id"];
    $defaultImagePath = "images/Default.png";

    // Check if the user's image field is empty
    $sql = "SELECT image FROM user WHERE id = $userId";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();

    if (empty($row["image"])) {
        // Update the user's image field with the default image path
        $updateSql = "UPDATE user SET image = '$defaultImagePath' WHERE id = $userId";
        $mysqli->query($updateSql);
    }
}

$mysqli->close();
?>