<?
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$targetAccountID = sqlTrim($_POST["targetAccountID"]);

if (!checkAct($accountID)) exit("-1");

if(checkGJP($gjp, $accountID)) {
	$q = $db->prepare("DELETE FROM blocked WHERE accountID = :a AND targetID = :t");
	$q->execute(array('a' => $accountID, 't' => $targetAccountID));
	exit("1");
} else exit("-1");
?>
