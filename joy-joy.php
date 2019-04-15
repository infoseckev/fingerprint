<?php

//header ( 'Content-type: application/json' );

$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "devices";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$browser = $_POST;

$stmt = $conn->prepare("INSERT INTO user_info (
                                `useragent`, 
                                `visitingsite`, 
                                `ip`,
                                `osname`,
                                `osversion`, 
                                `browsername`, 
                                `browserversion`, 
                                `appversion`,
                                `platform`,
                                `vendor`) 
                                VALUES (?,?,?,?,?,?,?,?,?,?)");
if ($stmt === false) {
    echo $conn->error;
} else {
    $stmt->bind_param("ssssssssss",$useragent,$site, $ip, $osname, $osversion, $browsername, $browserversion,  $appversion, $platform, $vendor);

    $useragent = $browser['useragent'];
    $site = $browser['site'];
    $ip = $browser['ip'];
    $osname = $browser['osname'];
    $osversion = $browser['osversion'];
    $browsername = $browser['browsername'];
    $browserversion = $browser['browserversion'];
    $appversion = $browser['appversion'];
    $platform = $browser['platform'];
    $vendor = $browser['vendor'];

    $stmt->execute();
}

$stmt->close();
$conn->close();

//echo json_encode("yay");

?>
