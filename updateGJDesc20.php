<?
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$levelDesc = sqlTrim($_POST["levelDesc"]);
$levelID = sqlTrim($_POST["levelID"]);

if(checkGJP($gjp, $accountID)) {
	$q = $db->prepare("UPDATE levels SET `desc` = '$levelDesc' WHERE levelID = '$levelID'");
	$q->execute();
	exit("1");
} else exit("-1");
?>