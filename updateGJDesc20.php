<?
include "connection.php";
require "lib.php";
$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$levelID = sqlTrim($_POST["levelID"]);
$levelDesc = sqlTrim($_POST["levelDesc"]);
if(disabled($accountID)) exit("-1");
if(checkGJP($gjp, $accountID)) {
	$a = $db->prepare("SELECT * FROM users WHERE accountID = '$accountID'");
	$a->execute();
	$r = $a->fetch(PDO::FETCH_ASSOC);
	$q = $db->prepare("SELECT * FROM levels WHERE levelID = '$levelID'");
	$q->execute();
	if($q->rowCount() > 0) {
		$res = $q->fetch(PDO::FETCH_ASSOC);
		if($res["userID"] == $r["userID"]) {
			$q1 = $db->prepare("UPDATE levels SET `desc` = '$levelDesc' WHERE levelID = '$levelID'");
			$q1->execute();
			exit("1");
		} else exit("-1");
	} else exit("-1");
} else {
	exit("-1");
}
?>
