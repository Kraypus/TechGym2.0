<?php
    session_start();

    if (isset($_SESSION["user_id"])) {
        
        $mysqli = require __DIR__ . "/database.php";
        
        $sql = "SELECT * FROM user
                WHERE id = {$_SESSION["user_id"]}";
                
        $result = $mysqli->query($sql);
        
        $user = $result->fetch_assoc();
    }

    if (!empty($_POST["email"])) {
        if (!empty($_POST["confirm_email"])) {
            if ($_POST["email"] == $_POST["confirm_email"]) {       
                mysqli_query($mysqli,"UPDATE user set email='" . $_POST['email'] . "' WHERE id = {$_SESSION["user_id"]}");
            }
        }
    }
    
    // Redirect back to the previous page
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
?>