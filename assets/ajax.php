<?php
include 'config.php';

$sql = "SELECT * FROM users WHERE id = ".$_SESSION["id"];
$result = mysqli_query($conn, $sql);
$users = array();

if (mysqli_num_rows($result) == 1){
    while ($row = mysqli_fetch_assoc($result)){
        $users[] = array(
            'id' => $row['id'],
            'name' => words($row['fname'],2),
            'avatar' => stripslashes($row['avatar']),
        );
    }
}

header('Content-Type: application/json');
echo json_encode($users);

// Create json objects
