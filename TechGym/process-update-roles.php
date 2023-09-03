<?php
require 'database.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_POST["userId"];
    $role = $_POST["role"];

    $mysqli = require __DIR__ . "/database.php";

    // Check if the user's role is valid, otherwise set it to "user"
    $validRoles = ["admin", "trainer", "user"];
    if (!in_array($role, $validRoles)) {
        $role = "user";
    }

    $updateSql = "UPDATE user SET role = ? WHERE id = ?";
    $stmt = $mysqli->prepare($updateSql);
    $stmt->bind_param("si", $role, $userId);
    $stmt->execute();
    $stmt->close();
}

// Redirect back to the previous page
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
?>
