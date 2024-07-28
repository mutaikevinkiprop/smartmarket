<?php
// Include database connection
include 'index.php';

// Check if the form is submitted
if (isset($_POST['upload']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // File upload handling
    $targetDirectory = "avatar/";
    $targetFile = $targetDirectory . basename($_FILES["new_avatar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a valid image
    $check = getimagesize($_FILES["new_avatar"]["tmp_name"]);
    if ($check === false) {
        echo "Sorry, the selected file is not a valid image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["new_avatar"]["size"] > 500000) {
        echo "Sorry, the selected file is too large.";
        $uploadOk = 0;
    }

    // Allow only certain file formats
    $allowedFormats = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowedFormats)) {
        echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        $uploadOk = 0;
    }

    // If $uploadOk is set to 0, display an error message
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // If everything is ok, try to upload file
        if (move_uploaded_file($_FILES["new_avatar"]["tmp_name"], $targetFile)) {
            // Update the user's avatar in the database
            $avatar_path = $targetFile;
            $sql_update_avatar = "UPDATE users SET avatar = ? WHERE id = ?";
            $stmt_update_avatar = $conn->prepare($sql_update_avatar);
            $stmt_update_avatar->bind_param("si", $avatar_path, $user_id);
            $stmt_update_avatar->execute();
            $stmt_update_avatar->close();

            // Redirect back to the profile page or any other page as needed
            header("Location: ");
            exit();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
