<?php
if (isset($_FILES["fileImg"]["name"])) {
    $id = $_POST["id"];

    // Get the previous image path
    $prevImagePathQuery = "SELECT image FROM user WHERE id = $id";
    $prevImagePathResult = mysqli_query($mysqli, $prevImagePathQuery);
    $prevImagePathRow = mysqli_fetch_assoc($prevImagePathResult);
    $prevImagePath = $prevImagePathRow['image'];

    // Delete the previous image from the "img" folder
    if (!empty($prevImagePath) && $prevImagePath != "images/Default.png") {
        $prevImageFilePath = "img/" . $prevImagePath;
        if (file_exists($prevImageFilePath)) {
            unlink($prevImageFilePath);
        }
    }

    // Upload the new image
    $src = $_FILES["fileImg"]["tmp_name"];

    // Fetch the users email from the database
    $emailQuery = "SELECT email FROM user WHERE id = $id";
    $emailResult = mysqli_query($mysqli, $emailQuery);
    $emailRow = mysqli_fetch_assoc($emailResult);
    $userEmail = $emailRow['email'];

    // Generate image name with current date and time
    $date = date("d-m-Y");
    $time = date("H-i-s");
    $imageName = $userEmail . "_" . $date . "_" . $time . ".jpg";

    $target = "img/" . $imageName;
    move_uploaded_file($src, $target);

    // Update the users image
    $query = "UPDATE user SET image = '$imageName' WHERE id = $id";
    mysqli_query($mysqli, $query);

    // Redirect back to the previous page
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
?>