<?
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$toAccountID = sqlTrim($_POST["toAccountID"]);
$subject = sqlTrim($_POST["subject"]);
$body = sqlTrim($_POST["body"]);

if(disabled($accountID)) exit("-1");

if(checkGJP($gjp, $accountID)) {
	if(canWriteTo($toAccountID)) {
		$q = $db->prepare("INSERT INTO messages (accountID, targetID, subject, body, uploadTime) VALUES ('$accountID', '$toAccountID', '$subject', '$body', '".time()."')");
		$q->execute();
		exit("1");
	} else {
		if(isMod($accountID)) {
			$q = $db->prepare("INSERT INTO messages (accountID, targetID, subject, body, uploadTime) VALUES ('$accountID', '$toAccountID', '$subject', '$body', '".time()."')");
			$q->execute();
			exit("1");
		} else {
			if(friendStatus($accountID, $toAccountID) == "1") {
				$q = $db->prepare("INSERT INTO messages (accountID, targetID, subject, body, uploadTime) VALUES ('$accountID', '$toAccountID', '$subject', '$body', '".time()."')");
				$q->execute();
				exit("1");
			} else exit("-1");
		}
	}
} else exit("-1");
?>