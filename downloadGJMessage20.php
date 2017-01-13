<?
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$messageID = sqlTrim($_POST["messageID"]);

if(checkGJP($gjp, $accountID)) {
	$q = $db->prepare("SELECT * FROM messages WHERE messageID = :m");
	$q->execute(array('m' => $messageID));
	$m = $q->fetch(PDO::FETCH_ASSOC);
	$qq = "";
	if($m["targetID"] == $accountID) 
		$qq = "SELECT * FROM users WHERE accountID = $accountID";
	else
		$qq = "SELECT * FROM users WHERE accountID = :t";
	$qa = $db->prepare($qq);
	$qa->execute(array('t' => $m["targetID"]));
	$u = $qa->fetch(PDO::FETCH_ASSOC);

	$q1 = $db->prepare("UPDATE messages SET `read` = 1 WHERE messageID = :m");
	$q1->execute(array('m' => $messageID));

	exit("6:".$u["userName"].":3:".$u["userID"].":2:".$u["accountID"].":1:".$m["messageID"].":4:".$m["subject"].":8:1:9:0:5:".$m["body"].":7:".makeTime($n["uploadTime"]));
} else exit("-1");
?>