<?php

if (empty($_POST["username"])) {
    $errors[] = $username_error = "Please enter your username";
}

if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $errors[] = $email_error = "Please enter your email";
}

if (empty($_POST["password"])) {
    $errors[] = $password_error = "Please enter your password";
}

if (strlen($_POST["password"]) < 8) {
    $errors[] = $password_error = "Password must be at least 8 characters"; 

}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    $errors[] = $password_error = "Password must contain at least 1 letter"; 
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    $errors[] = $password_error = "Password must contain at least 1 number"; 
}

if ($_POST["password"] !== $_POST["confirm_password"]) {
    $errors[] = $cpassword_error = "Passwords must match"; 
}

if (empty($_POST["confirm_password"])) {
    $errors[] = $cpassword_error = "Please confirm your password";
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO user (name, surname, username, email, password_hash, role)
        VALUES (?, ?, ?, ?, ?, ?)";
        
$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$role = "user";

$stmt->bind_param("ssssss",
                  $_POST["name"],
                  $_POST["surname"],
                  $_POST["username"],
                  $_POST["email"],
                  $password_hash,
                  $role);
                  
                  if ($stmt->execute()) {
                    // Set the default image for the new user
                    $userId = $stmt->insert_id;
                    $defaultImagePath = "images/Default.png";
                
                    // Get the users email
                    $emailQuery = "SELECT email FROM user WHERE id = $userId";
                    $emailResult = mysqli_query($mysqli, $emailQuery);
                    $emailRow = mysqli_fetch_assoc($emailResult);
                    $userEmail = $emailRow['email'];
                
                    // Generate image name with current date and time
                    $date = date("d-m-Y");
                    $time = date("H-i-s");
                    $imageName = $userEmail . "_" . $date . "_" . $time . ".jpg";
                
                    // Copy the default image to the users image
                    $defaultImageFilePath = "images/Default.png";
                    $target = "img/" . $imageName;
                    copy($defaultImageFilePath, $target);
                
                    // Update the users image with the new image path
                    $updateSql = "UPDATE user SET image = '$imageName' WHERE id = $userId";
                    $mysqli->query($updateSql);
                
                    // Redirect back to the previous page
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    exit;
                } else {
                    if ($mysqli->errno === 1062) {
                        die("Email already taken");
                    } else {
                        die($mysqli->error . " " . $mysqli->errno);
                    }
                }