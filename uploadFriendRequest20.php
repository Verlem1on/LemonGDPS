<?
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$comment = sqlTrim($_POST["comment"]);
$toAccountID = sqlTrim($_POST["toAccountID"]);

if(checkGJP($gjp, $accountID)) {
	$q = $db->prepare("INSERT INTO frRequests (accountID, targetID, comment, uploadTime) VALUES ('$accountID', '$toAccountID', '$comment', '".time()."')");
	$q->execute();
	exit("1");
} else {
	exit("-1");
}
?>