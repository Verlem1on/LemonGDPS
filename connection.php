<?php
$db = "";
$userName = "";
$password = "";

try {
	$db = new PDO("mysql:dbname=$db;host=localhost", $userName, $password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	exit("Error: " . $e->getMessage());
}
?>