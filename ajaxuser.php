<?php
include 'config.php';

// Query to get the users
$sql = "SELECT * FROM users WHERE id != ".$_SESSION["id"];
$result = mysqli_query($conn, $sql);
$users = array();


if (mysqli_num_rows($result) > 0){
    while ($row = mysqli_fetch_assoc($result)){
        $users[] = array(
            'id' => $row['id'],
            'name' => words($row['fname'],2),
            'avatar' => $row['avatar'],
        );
    }
}

// Query to get the last message
$sql = "SELECT * FROM messages ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$lastMessage = mysqli_fetch_assoc($result);

// Add the last message to the users array
foreach ($users as $key => $user) {
    $users[$key]['message'] = stripcslashes($lastMessage['message']);
}

header('Content-Type: application/json');
echo json_encode($users);