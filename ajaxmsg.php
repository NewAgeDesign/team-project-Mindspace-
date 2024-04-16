<?php
include 'config.php';
//Periodically send AJAX GET requests to a server-side script to get new messages.
//sanitize them first
$sender = mysqli_real_escape_string($conn, $_SESSION["id"]);
$receiver = mysqli_real_escape_string($conn, $_GET["id"]);

// First, check if the receiver exists in the users table
$sql = "SELECT * FROM users WHERE id = ".$receiver;
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) == 0){
    // If the receiver does not exist, return an empty array
    echo json_encode([]);
    exit;
}

// If the receiver exists, fetch the messages
$sql = "SELECT * FROM messages WHERE (senderid = ".$sender." AND receiverid = ".$receiver.") OR (senderid = ".$receiver." AND receiverid = ".$sender.") ORDER BY date_created DESC";
$result = mysqli_query($conn, $sql);
$messages = array();
if (mysqli_num_rows($result) > 0){
    while ($row = mysqli_fetch_assoc($result)){
        $messages[] = array(
            'id' => $row['id'],
            'sender_id' => $row['senderid'],
            'receiver_id' => $row['receiverid'],
            'message' => stripslashes($row['message']),
            'created_at' => $row['date_created']
        );
    }
}
header('Content-Type: application/json');
echo json_encode($messages);