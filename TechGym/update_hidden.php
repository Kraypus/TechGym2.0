<?php
require 'database.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $section = $_POST['section'];
  $hidden = $_POST['hidden'];
  $userId = $_SESSION['user_id'];

  // Check if the row exists for the given section
  $query = "SELECT * FROM user_hide_form WHERE form_id = $section AND user_id = $userId";
  $result = $mysqli->query($query);

  if ($result->num_rows > 0) {
    // Update the existing row
    $query = "UPDATE user_hide_form SET hidden = '$hidden' WHERE form_id = $section AND user_id = $userId";
    $mysqli->query($query);
  } else {
    // Insert a new row
    $query = "INSERT INTO user_hide_form (form_id, user_id, hidden) VALUES ($section, $userId, '$hidden')";
    $mysqli->query($query);
  }
}
?>