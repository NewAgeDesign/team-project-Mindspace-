<?php
session_start();
$dbserver = "localhost";
$dbuname = "root";
$dbpsw = "";
$db = "teamproject";

$conn = mysqli_connect($dbserver, $dbuname, $dbpsw, $db);

if(!$conn){
    die("Error, Connection Failed: " . mysqli_connect_error());
}
function words($string, $num) {
    $words = explode(' ', $string);

    foreach ($words as $i => $word) {
        if (strlen($word) > 7) {
            $words[$i] = $word[0];
        }
    }

    return implode(' ', array_slice($words, 0, $num));
}

