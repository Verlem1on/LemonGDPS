<?
require "lib.php";
include "connection.php";

tryKillAccs();

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$comment = sqlTrim($_POST["comment"]);
$levelID = sqlTrim($_POST["levelID"]);

if (!checkAct($accountID)) exit("-1");

if(checkGJP($gjp, $accountID)) {
	$q = $db->prepare("SELECT * FROM users WHERE accountID = :a");
	$q->execute([':a' => $accountID]);
	$r = $q->fetch(PDO::FETCH_ASSOC);
	if(disabled($accountID)) exit("-10");
	$q = $db->prepare("INSERT INTO comments (userID, accountID, accountComment, uploadTime, comment, levelID) VALUES ('".$r["userID"]."', :a, '0', '".time()."', :c, :l)");
	$q->execute([':a' => $accountID, ':c' => $comment, ':l' => $levelID]);
	exit("1");
} else exit("-1");
?>
