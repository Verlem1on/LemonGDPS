<?php
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$comment = sqlTrim($_POST["comment"]);

if (checkGJP($gjp, $accountID)) {
	$a = $db->prepare("SELECT * FROM users WHERE accountID = '$accountID'");
	$a->execute();
	$r = $a->fetch(PDO::FETCH_ASSOC);
	$q = $db->prepare("INSERT INTO comments (accountID, userID, comment, uploadTime, accountComment, levelID) VALUES ('$accountID', '".$r["userID"]."', '$comment', '".time()."', '1', '0')");
	$q->execute();
	exit("1");
} else {
	exit("-1");
}
?>