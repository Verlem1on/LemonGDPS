<?
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$targetAccountID = sqlTrim($_POST["targetAccountID"]);
$isSender = sqlTrim($_POST["isSender"]);

if(disabled($accountID)) exit("-1");

if(checkGJP($gjp, $accountID)) {
	if($targetAccountID != "0") {
		if($isSender != "0") {
			$q = $db->prepare("DELETE FROM frRequests WHERE accountID = '$accountID' AND targetID = '$targetAccountID'");
			$q->execute();
			exit("1");
		} else {
			$q = $db->prepare("DELETE FROM frRequests WHERE targetID = '$accountID' AND accountID = '$targetAccountID'");
			$q->execute();
			exit("1");
		}
	} 
} else exit("-1");
?>