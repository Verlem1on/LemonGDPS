<?php
require_once "settings/settings.php";

$db = DB_DATABASE;
$userName = DB_LOGIN;
$password = DB_PASSWORD;
$server = DB_SERVER;

try {
	$db = new PDO("mysql:dbname=$db;host=localhost", $userName, $password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	exit("[-] Fatal error: " . $e->getMessage());
}
?>