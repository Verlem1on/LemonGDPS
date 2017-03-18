<?php
require_once "lib.php";
include "connection.php";
require_once "unregistered.php";

updateCP();
tryKillAccs();

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
$icon = $_POST['icon'];
$udid = $_POST['udid'];
#2.1
$accSpider = $_POST["accSpider"];
$accExplosion = $_POST["accExplosion"];
$diamonds = $_POST["diamonds"];

if ($accountID != '') {
	if(disabled($accountID)) exit("-1");
	if (!checkAct($accountID)) exit("-1");
	if (checkGJP($gjp, $accountID)) {
		# Anticheat

		$q = $db->prepare("SELECT * FROM levels");
		$q->execute();
		$levels = $q->fetchAll();

		$q = $db->prepare("SELECT * FROM mappacks");
		$q->execute();
		$mp = $q->fetchAll();

		$maxStars = 187;
		$maxCoins = 63;
		$maxUC = 0;
		$maxDemons = 3;

		for($i = 0; $i < count($levels); $i++) {
			$level = $levels[$i];
			$maxStars += $level["stars"];
			$maxDemons += $level["demon"];
			if($level["verifiedCoins"] == "1") {
				$maxUC += $level["coins"];
			}
		}

		for($i = 0; $i < count($mp); $i++) {
			$m = $mp[$i];
			$maxStars += $m["stars"];
			$maxCoins += $m["coins"];
		}

		if($stars > $maxStars || $coins > $maxCoins || $userCoins > $maxUC || $demons > $maxDemons) {
			$q = $db->prepare("UPDATE accounts SET banned = '1' WHERE accountID = :a");
			$q->execute(array('a' => $accountID));
		}

		$a = $db->prepare("SELECT * FROM accounts WHERE accountID = :a");
		$a->execute([':a' => $accountID]);
		$r1 = $a->fetch(PDO::FETCH_ASSOC);

		if($r1["banned"] == "1") quit($accountID);

		$q = $db->prepare("UPDATE users SET stars = :stars, coins = :coins, userCoins = :userCoins, demons = :demons, special = :special, icon = :accIcon, ship = :accShip, ball = :accBall, ufo = :accBird, wave = :accDart, robot = :accRobot, glow = :accGlow, pColor = :pColor, sColor = :sColor, iconType = :iconType, diamonds = :d, explosion = :e, spider = :s, shareIcon = :si WHERE accountID = :accountID");
		$q->execute(array('d' => $diamonds, 'e' => $accExplosion, 's' => $accSpider, 'si' => $icon, 'stars' => $stars, 'coins' => $coins, 'userCoins' => $userCoins, 'demons' => $demons, 'special' => $special, 'accIcon' => $accIcon, 'accBall' => $accBall, 'accShip' => $accShip, 'accBird' => $accBird, 'accDart' => $accDart, 'accRobot' => $accRobot, 'accGlow' => $accGlow, 'pColor' => $pColor, 'sColor' => $sColor, 'iconType' => $iconType, 'accountID' => $accountID));
		quit($accountID);
	} else {
		exit("-1");
	}
} else {

	$uID = tryCreateUser($udid, $userName);

	if ($uID != '') {

        $q = $db->prepare("SELECT * FROM levels");
        $q->execute();
        $levels = $q->fetchAll();

        $q = $db->prepare("SELECT * FROM mappacks");
        $q->execute();
        $mp = $q->fetchAll();

        $maxStars = 187;
        $maxCoins = 63;
        $maxUC = 0;
        $maxDemons = 3;

        for($i = 0; $i < count($levels); $i++) {
            $level = $levels[$i];
            $maxStars += $level["stars"];
            $maxDemons += $level["demon"];
            if($level["verifiedCoins"] == "1") {
                $maxUC += $level["coins"];
            }
        }

        for($i = 0; $i < count($mp); $i++) {
            $m = $mp[$i];
            $maxStars += $m["stars"];
            $maxCoins += $m["coins"];
        }

        if($stars > $maxStars || $coins > $maxCoins || $userCoins > $maxUC || $demons > $maxDemons) exit("-1");

		$q = $db->prepare("UPDATE users SET stars = :stars, coins = :coins, userCoins = :userCoins, demons = :demons, special = :special, icon = :accIcon, ship = :accShip, ball = :accBall, ufo = :accBird, wave = :accDart, robot = :accRobot, glow = :accGlow, pColor = :pColor, sColor = :sColor, iconType = :iconType, diamonds = :d, explosion = :e, spider = :s, shareIcon = :si WHERE userID = :userID");
		$q->execute(array('d' => $diamonds, 'e' => $accExplosion, 's' => $accSpider, 'si' => $icon, 'userID' => $uID, 'stars' => $stars, 'coins' => $coins, 'userCoins' => $userCoins, 'demons' => $demons, 'special' => $special, 'accIcon' => $accIcon, 'accBall' => $accBall, 'accShip' => $accShip, 'accBird' => $accBird, 'accDart' => $accDart, 'accRobot' => $accRobot, 'accGlow' => $accGlow, 'pColor' => $pColor, 'sColor' => $sColor, 'iconType' => $iconType));

		exit($uID);

	} else exit("-1");

}

function quit($accountID) {
	include "connection.php";
	$q1 = $db->prepare("SELECT * FROM users WHERE accountID = :a");
	$q1->execute([':a' => $accountID]);
	$r = $q1->fetch(PDO::FETCH_ASSOC);
	exit($r["userID"]);
}
?>
