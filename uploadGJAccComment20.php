<?php
include "connection.php";
require "lib.php";

tryKillAccs();

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$comment = sqlTrim($_POST["comment"]);

if(disabled($accountID)) exit("-1");
if (!checkAct($accountID)) exit("-1");

if (checkGJP($gjp, $accountID)) {
	if (checkLimit($accountID, 'accComment')) exit("-1");
	changeTime($accountID, 'accComment');
	increaseValue($accountID, 'accComment');
	tryKillValues($accountID, 'accComment');

	$a = $db->prepare("SELECT * FROM users WHERE accountID = :a");
	$a->execute([':a' => $accountID]);
	$r = $a->fetch(PDO::FETCH_ASSOC);
	$q = $db->prepare("INSERT INTO comments (accountID, userID, comment, uploadTime, accountComment, levelID) VALUES (:a, '".$r["userID"]."', :c, '".time()."', '1', '0')");
	$q->execute([':a' => $accountID, ':c' => $comment]);

	exit("1");
} else {
	exit("-1");
}
?>
