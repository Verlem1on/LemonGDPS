<?
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$targetAccountID = sqlTrim($_POST["targetAccountID"]);
$requestID = sqlTrim($_POST["requestID"]);

if(disabled($accountID)) exit("-1");

if(checkGJP($gjp, $accountID)) {
	$q = $db->prepare("DELETE FROM frRequests WHERE requestID = :r");
	$q->execute(array('r' => $requestID));
	$q = $db->prepare("INSERT INTO friends (accountID, targetID, new) VALUES (:a, :t, '1')");
	$q->execute(array('a' => $accountID, 't' => $targetAccountID));
	$q = $db->prepare("INSERT INTO friends (accountID, targetID, new) VALUES (:t, :a, '1')");
	$q->execute(array('a' => $accountID, 't' => $targetAccountID));
	exit("1");
} else exit("-1");
?>