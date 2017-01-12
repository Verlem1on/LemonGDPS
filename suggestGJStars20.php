<?
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$stars = sqlTrim($_POST["stars"]);
$featured = sqlTrim($_POST["feature"]);
$levelID = sqlTrim($_POST["levelID"]);

if(!checkGJP($gjp, $accountID)) exit("-1");
$q = $db->prepare("SELECT * FROM accounts WHERE accountID = '$accountID'");
$q->execute();
$r = $q->fetch(PDO::FETCH_ASSOC);

if($r["mod"] != "1") exit("-1");

unset($q);

switch ($stars) {
	case '1':
		$q = $db->prepare("UPDATE levels SET diff = '50', auto = '1', demon = '0', stars = '$stars', featured = '$featured' WHERE levelID = '$levelID'");
		$q->execute();
		echo("1");
		break;
	
	case '2':
		$q = $db->prepare("UPDATE levels SET diff = '10', auto = '0', demon = '0', stars = '$stars', featured = '$featured' WHERE levelID = '$levelID'");
		$q->execute();
		echo("1");
		break;

	case '3':
		$q = $db->prepare("UPDATE levels SET diff = '20', auto = '0', demon = '0', stars = '$stars', featured = '$featured' WHERE levelID = '$levelID'");
		$q->execute();
		echo("1");
		break;

	case '4':
		$q = $db->prepare("UPDATE levels SET diff = '30', auto = '0', demon = '0', stars = '$stars', featured = '$featured' WHERE levelID = '$levelID'");
		$q->execute();
		echo("1");
		break;

	case '5':
		$q = $db->prepare("UPDATE levels SET diff = '30', auto = '0', demon = '0', stars = '$stars', featured = '$featured' WHERE levelID = '$levelID'");
		$q->execute();
		echo("1");
		break;

	case '6':
		$q = $db->prepare("UPDATE levels SET diff = '40', auto = '0', demon = '0', stars = '$stars', featured = '$featured' WHERE levelID = '$levelID'");
		$q->execute();
		echo("1");
		break;

	case '7':
		$q = $db->prepare("UPDATE levels SET diff = '40', auto = '0', demon = '0', stars = '$stars', featured = '$featured' WHERE levelID = '$levelID'");
		$q->execute();
		echo("1");
		break;

	case '8':
		$q = $db->prepare("UPDATE levels SET diff = '50', auto = '0', demon = '0', stars = '$stars', featured = '$featured' WHERE levelID = '$levelID'");
		$q->execute();
		echo("1");
		break;

	case '9':
		$q = $db->prepare("UPDATE levels SET diff = '50', auto = '0', demon = '0', stars = '$stars', featured = '$featured' WHERE levelID = '$levelID'");
		$q->execute();
		echo("1");
		break;

	case '10':
		$q = $db->prepare("UPDATE levels SET diff = '50', auto = '0', demon = '1', stars = '$stars', featured = '$featured' WHERE levelID = '$levelID'");
		$q->execute();
		echo("1");
		break;

	default:
		$q = $db->prepare("UPDATE levels SET diff = '0', auto = '0', demon = '0', stars = '0', featured = '0' WHERE levelID = '$levelID'");
		$q->execute();
		echo("1");
		break;
}

if($featured != "0") {
	$q = $db->prepare("UPDATE levels SET verifiedCoins = '1' WHERE levelID = '$levelID'");
	$q->execute();
}

exit;
?>