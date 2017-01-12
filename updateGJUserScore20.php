<?php
require "lib.php";
include "connection.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$userName = sqlTrim($_POST["userName"]);
$stars = sqlTrim($_POST["stars"]);
$demons = sqlTrim($_POST["demons"]);
$coins = sqlTrim($_POST["coins"]);
$userCoins = sqlTrim($_POST["userCoins"]);
$special = sqlTrim($_POST["special"]);
$accIcon = sqlTrim($_POST["accIcon"]);
$accShip = sqlTrim($_POST["accShip"]);
$accBall = sqlTrim($_POST["accBall"]);
$accBird = sqlTrim($_POST["accBird"]);
$accDart = sqlTrim($_POST["accDart"]);
$accRobot = sqlTrim($_POST["accRobot"]);
$accGlow = sqlTrim($_POST["accGlow"]);
$pColor = sqlTrim($_POST["color1"]);
$sColor = sqlTrim($_POST["color2"]);
$iconType = sqlTrim($_POST["iconType"]);

if(disabled($accountID)) exit("-1");

if (checkGJP($gjp, $accountID)) {
	$a = $db->prepare("SELECT * FROM accounts WHERE accountID = '$accountID'");
	$a->execute();
	$r1 = $a->fetch(PDO::FETCH_ASSOC);

	if($r1["banned"] == "1") quit($accountID);;

	$q = $db->prepare("UPDATE users SET stars = '$stars', coins = '$coins', userCoins = '$userCoins', demons = '$demons', special = '$special', icon = '$accIcon', ship = '$accShip', ball = '$accBall', ufo = '$accBird', wave = '$accDart', robot = '$accRobot', glow = '$accGlow', pColor = '$pColor', sColor = '$sColor', iconType = '$iconType' WHERE accountID = '$accountID'");
	$q->execute();
	quit($accountID);
} else {
	exit("-1");
}

function quit($accountID) {
	include "connection.php";
	$q1 = $db->prepare("SELECT * FROM users WHERE accountID = '$accountID'");
	$q1->execute();
	$r = $q1->fetch(PDO::FETCH_ASSOC);
	exit($r["userID"]);
}
?>