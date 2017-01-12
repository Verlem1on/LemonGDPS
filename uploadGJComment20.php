<?
require "lib.php";
include "connection.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$comment = sqlTrim($_POST["comment"]);
$levelID = sqlTrim($_POST["levelID"]);

if(checkGJP($gjp, $accountID)) {
	$q = $db->prepare("SELECT * FROM users WHERE accountID = '$accountID'");
	$q->execute();
	$r = $q->fetch(PDO::FETCH_ASSOC);
	if(disabled($accountID)) exit("-10");
	$q = $db->prepare("INSERT INTO comments (userID, accountID, accountComment, uploadTime, comment, levelID) VALUES ('".$r["userID"]."', '$accountID', '0', '".time()."', '$comment', '$levelID')");
	$q->execute();
	exit("1");
} else exit("-1");
?>