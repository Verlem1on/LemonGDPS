<?
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$targetAccountID = sqlTrim($_POST["targetAccountID"]);

if (!checkAct($accountID)) exit("-1");

if(checkGJP($gjp, $accountID)) {
	$q = $db->prepare("DELETE FROM friends WHERE accountID = :a AND targetID = :t; DELETE FROM friends WHERE accountID = :t AND targetID = :a; DELETE FROM messages WHERE accountID = :a AND targetID = :t; DELETE FROM messages WHERE accountID = :t AND targetID = :a; DELETE FROM frRequests WHERE accountID = :a AND targetID = :t; DELETE FROM frRequests WHERE accountID = :t AND targetID = :a; INSERT INTO blocked (accountID, targetID) VALUES (:a, :t)");
	$q->execute(array('t' => $targetAccountID, 'a' => $accountID));
	exit("1");
} else exit("-1");
?>
