<?php
require 'database.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$mysqli = require __DIR__ . "/database.php";

// Process the form submission
if (isset($_POST["submit"])) {
    $formId = $_POST["form_id"];
    $userId = $_SESSION["user_id"];

    // Process the table header
    $headerContent1 = $_POST["header_content1"];
    $headerContent2 = $_POST["header_content2"];
    $headerContent3 = $_POST["header_content3"];

    // Update or insert the table header in the database
    $sql = "SELECT * FROM trainer_table WHERE form_id = $formId AND user_id = $userId AND row_id = -1";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        // The table header exists, update the values
        $sql = "UPDATE trainer_table SET content1 = '$headerContent1', content2 = '$headerContent2', content3 = '$headerContent3' WHERE form_id = $formId AND user_id = $userId AND row_id = -1";
        $mysqli->query($sql);
    } else {
        // The table header doesn't exist, insert a new row
        $sql = "INSERT INTO trainer_table (form_id, user_id, row_id, content1, content2, content3)
                VALUES ($formId, $userId, -1, '$headerContent1', '$headerContent2', '$headerContent3')";
        $mysqli->query($sql);
    }

    // Process the table rows
    for ($i = 0; $i < count($_POST["content1"]); $i++) {
        $content1 = $_POST["content1"][$i];
        $content2 = $_POST["content2"][$i];
        $content3 = $_POST["content3"][$i];

        // Update or insert the table row in the database
        $sql = "SELECT * FROM trainer_table WHERE form_id = $formId AND user_id = $userId AND row_id = $i";
        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
            // The table row exists, update the values
            $sql = "UPDATE trainer_table SET content1 = '$content1', content2 = '$content2', content3 = '$content3' WHERE form_id = $formId AND user_id = $userId AND row_id = $i";
            $mysqli->query($sql);
        } else {
            // The table row doesn't exist, insert a new row
            $sql = "INSERT INTO trainer_table (form_id, user_id, row_id, content1, content2, content3)
                    VALUES ($formId, $userId, $i, '$content1', '$content2', '$content3')";
            $mysqli->query($sql);
        }
    }

    // Process the table description and title
    $tableDesc = $_POST["content4"];
    $tableTitle = $_POST["title4"];

    // Update or insert the values in the user_profile table
    $sql = "SELECT * FROM user_profile WHERE user_id = $userId AND form_id = 3";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        // The user profile exists for form_id 3, update the values
        $sql = "UPDATE user_profile SET content = '$tableDesc', title = '$tableTitle' WHERE user_id = $userId AND form_id = 3";
        $mysqli->query($sql);
    } else {
        // The user profile doesn't exist for form_id 3, insert a new row
        $sql = "INSERT INTO user_profile (user_id, form_id, content, title)
                VALUES ($userId, 3, '$tableDesc', '$tableTitle')";
        $mysqli->query($sql);
    }

    // Redirect back to the previous page
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
?>