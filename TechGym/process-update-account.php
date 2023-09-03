<?php
    session_start();

    if (isset($_SESSION["user_id"])) {
        
        $mysqli = require __DIR__ . "/database.php";
        
        $sql = "SELECT * FROM user
                WHERE id = {$_SESSION["user_id"]}";
                
        $result = $mysqli->query($sql);
        
        $user = $result->fetch_assoc();
    }

    if (!empty($_POST["name"])) {
        mysqli_query($mysqli,"UPDATE user set name='" . $_POST['name'] . "' WHERE id = {$_SESSION["user_id"]}");
    }

    if (!empty($_POST["surname"])) {
        mysqli_query($mysqli,"UPDATE user set surname='" . $_POST['surname'] . "' WHERE id = {$_SESSION["user_id"]}");
    }
    
    if (!empty($_POST["username"])) {
        mysqli_query($mysqli,"UPDATE user set username='" . $_POST['username'] . "' WHERE id = {$_SESSION["user_id"]}");
    }

    // Redirect back to the previous page
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
?>