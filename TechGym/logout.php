<?php
session_start();

// Get the previous page URL
$previousPage = $_SERVER['HTTP_REFERER'];

// Check if the previous page was profile.php and if the user_id is set in the session
if (strpos($previousPage, "profile.php") !== false && isset($_SESSION["user_id"])) {
    $userId = $_SESSION["user_id"];

    // Redirect to profile-displayed.php with the user_id
    header("Location: profile-displayed.php?user_id=" . $userId);

    session_destroy();
    exit;
}

// If the previous page was not profile.php or user_id is not set, perform the default logout action
session_destroy();

// Redirect back to the previous page
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
?>
