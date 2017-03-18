<?
include "connection.php";
require "lib.php";

tryKillAccs();

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$comment = sqlTrim($_POST["comment"]);
$toAccountID = sqlTrim($_POST["toAccountID"]);

if (!checkAct($accountID)) exit("-1");

if(checkGJP($gjp, $accountID)) {
	if (!canAddToFriends($toAccountID)) exit('-1');

	$q = $db->prepare("INSERT INTO frRequests (accountID, targetID, comment, uploadTime) VALUES (:a, :t, :c, '".time()."')");
	$q->execute([':a' => $accountID, ':c' => $comment, ':t' => $toAccountID]);
	exit("1");
} else {
	exit("-1");
}
?>
