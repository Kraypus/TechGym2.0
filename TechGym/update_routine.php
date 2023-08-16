<?php
require 'database.php';
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];
    $form_id = $_POST["form_id"];

    // Default the display value to "yes"
    $display = "yes";

    // Check if a row exists for the user and form
    $query = "SELECT * FROM routine WHERE user_id = ? AND form_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ii", $user_id, $form_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        // Row exists, get the current display value
        $current_display = $row["display"];

        // Update the display value
        $new_display = $current_display == "yes" ? "no" : "yes";

        $update_query = "UPDATE routine SET display = ? WHERE user_id = ? AND form_id = ?";
        $update_stmt = $mysqli->prepare($update_query);
        $update_stmt->bind_param("sii", $new_display, $user_id, $form_id);
        if ($update_stmt->execute()) {
            $_SESSION['display'] = $new_display; // Update the session display value
            echo $new_display; // Return new display value
        } else {
            echo "Update failed: " . $update_stmt->error;
        }
    } else {
        // Row doesn't exist, insert new row
        $insert_query = "INSERT INTO routine (user_id, form_id, display, subscribers) VALUES (?, ?, ?, 0)";
        $insert_stmt = $mysqli->prepare($insert_query);

        // Use $display instead of $new_display
        $insert_stmt->bind_param("iis", $user_id, $form_id, $display); // Use $display here
        if ($insert_stmt->execute()) {
            $_SESSION['display'] = $display; // Set the session display value
            echo $display; // Return display value
        } else {
            echo "Insert failed: " . $insert_stmt->error;
        }
    }
    exit;
}
?>