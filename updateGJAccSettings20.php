<?
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$frS = sqlTrim($_POST["frS"]);
$mS = sqlTrim($_POST["mS"]);
$yt = sqlTrim($_POST["yt"]);

if(checkGJP($gjp, $accountID)) {
	$q = $db->prepare("UPDATE accounts SET msgAllowed = '$mS', frAllowed = '$frS', ytLink = '$yt' WHERE accountID = '$accountID'");
	$q->execute();
	exit("1");
} else {
	exit("-1");
}
?>