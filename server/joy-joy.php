<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//header ( 'Content-type: application/json' );

$servername = "localhost";
$username = "root";
$password = "";
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
                                `vendor`,
                                `endpoint`,
                                `expirationTime`,
                                `p256dh`,
                                `auth`)
                                VALUES (?,?,?,?,?,?,?,?,?,?, ?, ?,?, ?)");
if ($stmt === false) {
    echo $conn->error;
} else {
    $stmt->bind_param("ssssssssssssss",$useragent,$site, $ip, $osname, $osversion, $browsername, $browserversion,
    $appversion, $platform, $vendor, $endpoint, $expirationTime, $p256dh, $auth);

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
    $endpoint = $browser['endpoint'];
    $expirationTime = $browser['expirationTime'];
    $p256dh = $browser['p256dh'];
    $auth = $browser['auth'];

    $stmt->execute();
}

$stmt->close();
$conn->close();

//echo json_encode("yay");

?>
