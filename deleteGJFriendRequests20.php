<?
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$targetAccountID = sqlTrim($_POST["targetAccountID"]);
$isSender = sqlTrim($_POST["isSender"]);
$accounts = sqlTrim($_POST["accounts"]);

if(disabled($accountID)) exit("-1");

if(checkGJP($gjp, $accountID)) {
	if($targetAccountID != "0") {
		if($isSender != "0") {
			$q = $db->prepare("DELETE FROM frRequests WHERE accountID = :a AND targetID = :t");
			$q->execute(array('a' => $accountID, 't' => $targetAccountID));
			exit("1");
		} else {
			$q = $db->prepare("DELETE FROM frRequests WHERE targetID = :a AND accountID = :t");
			$q->execute(array('a' => $accountID, 't' => $targetAccountID));
			exit("1");
		}
	}

	if($accounts != "") {
		if($isSender != "0") {
			$accArr = explode(',', $accounts);
			foreach ($accArr as $acc) {
				$q = $db->prepare("DELETE FROM frRequests WHERE accountID = :a AND targetID = :t");
				$q->execute(array('a' => $accountID, 't' => $acc));
			}
			exit("1");
		} else {
			$accArr = explode(',', $accounts);
			foreach ($accArr as $acc) {
				$q = $db->prepare("DELETE FROM frRequests WHERE targetID = :a AND accountID = :t");
				$q->execute(array('a' => $accountID, 't' => $acc));
			}
			exit("1");
		}
	}
} else exit("-1");
?>