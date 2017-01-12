<?
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$type = sqlTrim($_POST["type"]);

if(checkGJP($gjp, $accountID)) {
	$q = $db->prepare("SELECT * FROM friends WHERE accountID = '$accountID'");
	$q->execute();

	if($q->rowCount() <= 0) exit("-2");

	$r = $q->fetchAll();

	for($i = 0; $i < count($r); $i++) {
		$u = $r[$i]["targetID"];
		$q1 = $db->prepare("SELECT * FROM users WHERE accountID = '$u'");
		$q1->execute();
		$user = $q1->fetch(PDO::FETCH_ASSOC);

		echo "1:".$user["userName"].":2:".$user["userID"].":9:".$user["icon"].":10:".$user["pColor"].":11:".$user["sColor"].":14:".$user["iconType"].":15:".$user["special"].":16:".$user["accountID"].":18:".$user["new"].":41:".$user["new"]."|";
	}
} else exit("-1");
?>