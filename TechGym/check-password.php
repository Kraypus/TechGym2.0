<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $mysqli = require __DIR__ . "/database.php";

    $sql = sprintf("SELECT * FROM user WHERE email = '%s'", $mysqli->real_escape_string($email));

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user["password_hash"])) {
        // Password is valid
        $response = [
            "valid" => true,
        ];
    } else {
        // Password is invalid
        $response = [
            "valid" => false,
            "errorMessage" => "Password is incorrect",
        ];

    }

    header("Content-Type: application/json");
    echo json_encode($response);
    exit;
}
