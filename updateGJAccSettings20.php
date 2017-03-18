<?
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$frS = sqlTrim($_POST["frS"]);
$mS = sqlTrim($_POST["mS"]);
$yt = sqlTrim($_POST["yt"]);
$twitter = sqlTrim($_POST["twitter"]);
$twitch = sqlTrim($_POST["twitch"]);

if(disabled($accountID)) exit("-1");
if (!checkAct($accountID)) exit("-1");

tryKillAccs();

if(checkGJP($gjp, $accountID)) {
	$q = $db->prepare("UPDATE accounts SET msgAllowed = :m, frAllowed = :f, ytLink = :y, twitch = :tv, twitter = :tw WHERE accountID = :a");
	$q->execute(array('m' => $mS, 'f' => $frS, 'y' => $yt, 'tv' => $twitch, 'tw' => $twitter, 'a' => $accountID));
	exit("1");
} else {
	exit("-1");
}
?>
