<?
include "connection.php";
require "lib.php";

tryKillAccs();

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$comment = sqlTrim($_POST["comment"]);
$toAccountID = sqlTrim($_POST["toAccountID"]);

if(disabled($accountID)) exit("-1");
if (!checkAct($accountID)) exit("-1");

if(checkGJP($gjp, $accountID)) {
	$q = $db->prepare("INSERT INTO frRequests (accountID, targetID, comment, uploadTime) VALUES (:a, :t, :c, '".time()."')");
	$q->execute([':a' => $accountID, ':t' => $toAccountID, ':c' => $comment]);
	exit("1");
} else {
	exit("-1");
}
?>
