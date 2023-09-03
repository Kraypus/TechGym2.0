<?php
    session_start();

    if (isset($_SESSION["user_id"])) {
        
        $mysqli = require __DIR__ . "/database.php";
        
        $sql = "SELECT * FROM user
                WHERE id = {$_SESSION["user_id"]}";
                
        $result = $mysqli->query($sql);
        
        $user = $result->fetch_assoc();
    }

    if (!empty($_POST["password"])) {
        if (!empty($_POST["confirm_password"])) {
            if ($_POST["password"] == $_POST["confirm_password"]) {
                $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);   
                mysqli_query($mysqli,"UPDATE user set password_hash='" . $password_hash . "' WHERE id = {$_SESSION["user_id"]}");
            }
        }
    }
    
    // Redirect back to the previous page
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
?>