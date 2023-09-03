<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the user ID from the form submission
    $userId = $_POST["userId"];

    // Delete the user from the database
    $mysqli = require __DIR__ . "/database.php";
    $deleteSql = "DELETE FROM user WHERE id = ?";
    $stmt = $mysqli->prepare($deleteSql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();
}

// Redirect back to the previous page
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
?>