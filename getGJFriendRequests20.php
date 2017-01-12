<?
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$page = sqlTrim($_POST["page"]);
$getSent = sqlTrim($_POST["getSent"]);

if(disabled($accountID)) exit("-1");

if(checkGJP($gjp, $accountID)) {
	if($getSent == "1") {
		$q = $db->prepare("SELECT * FROM frRequests WHERE accountID = :accountID");
		$q->execute(array('accountID' => $accountID));
		$a = $db->prepare("SELECT * FROM users");
		$a->execute();

		if($q->rowCount() <= 0) exit("-2");

		$r = $q->fetchAll();
		$ar = $a->fetchAll();

		for($i = 0; $i < count($r); $i++) {
			foreach ($ar as $user) {
				$dat = $r[$i];
				if($dat["targetID"] == $user["accountID"]) {
					echo "1:".$user["userName"].":2:".$user["userID"].":9:".$user["icon"].":10:".$user["pColor"].":11:".$user["sColor"].":14:".$user["iconType"].":15:".$user["special"].":16:".$user["accountID"].":32:".$dat["requestID"].":35:".$dat["comment"].":41:".$dat["read"].":37:".makeTime($dat["uploadTime"]);
				}
			}
			if($i < count($r) - 1)
				echo "|";
			else
				break;
		}

		exit("#".count($r).":0:10");
	} else {
		$q = $db->prepare("SELECT * FROM frRequests WHERE targetID = :targetID");
		$q->execute(array('targetID' => $accountID));
		$a = $db->prepare("SELECT * FROM users");
		$a->execute();

		if($q->rowCount() <= 0) exit("-2");

		$r = $q->fetchAll();
		$ar = $a->fetchAll();

		for($i = 0; $i < count($r); $i++) {
			foreach ($ar as $user) {
				$dat = $r[$i];
				if($dat["accountID"] == $user["accountID"]) {
					echo "1:".$user["userName"].":2:".$user["userID"].":9:".$user["icon"].":10:".$user["pColor"].":11:".$user["sColor"].":14:".$user["iconType"].":15:".$user["special"].":16:".$user["accountID"].":32:".$dat["requestID"].":35:".$dat["comment"].":41:".$dat["read"].":37:".makeTime($dat["uploadTime"]);
				}
			}
			if($i < count($r) - 1)
				echo "|";
			else
				break;
		}

		exit("#".count($r).":0:10");
	}
} else {
	exit("-1");
}
?>