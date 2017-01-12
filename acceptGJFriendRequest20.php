<?
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$targetAccountID = sqlTrim($_POST["targetAccountID"]);
$requestID = sqlTrim($_POST["requestID"]);

if(disabled($accountID)) exit("-1");

if(checkGJP($gjp, $accountID)) {
	$q = $db->prepare("DELETE FROM frRequests WHERE requestID = '$requestID'");
	$q->execute();
	$q = $db->prepare("INSERT INTO friends (accountID, targetID, new) VALUES ('$accountID', '$targetAccountID', '1')");
	$q->execute();
	$q = $db->prepare("INSERT INTO friends (accountID, targetID, new) VALUES ('$targetAccountID', '$accountID', '1')");
	$q->execute();
	exit("1");
} else exit("-1");
?>