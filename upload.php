<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['croppedImage'])) {
        $file_name = $_FILES['croppedImage']['name'];
        $file_tmp = $_FILES['croppedImage']['tmp_name'];
        $file_ext = strtolower(end(explode('.', $_FILES['croppedImage']['name'])));

        $username = $_SESSION['username']; // Replace this with the actual username
        $date = date('Y-m-d-H-i-s');
        $new_file_name = "mindspace-" . $username . "-" . $date . "." . $file_ext;
        $file_path = "profile/" . $new_file_name;

        move_uploaded_file($file_tmp, $file_path);

        // Update the user's avatar in the database
        $sql = "UPDATE users SET avatar = '".$file_path."' WHERE username = '".$username."'";
        mysqli_query($conn, $sql);
        
        $sql = "SELECT * FROM users WHERE username = '".$username."'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);

        $_SESSION['avatar'] = $user['avatar'];
        header('Location: index.php');
    }
}