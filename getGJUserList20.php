<?
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$type = sqlTrim($_POST["type"]);

if(disabled($accountID)) exit("-1");

if(checkGJP($gjp, $accountID)) {
	switch ($type) {
		case '0':
			$q = $db->prepare("SELECT * FROM friends WHERE accountID = :a");
			$q->execute(array('a' => $accountID));
			$a = $db->prepare("UPDATE friends SET new = 0 WHERE accountID = :a");
			$a->execute(array('a' => $accountID));
			
			if($q->rowCount() <= 0) exit("-2");

			$r = $q->fetchAll();

			for($i = 0; $i < count($r); $i++) {
				$u = $r[$i]["targetID"];
				$q1 = $db->prepare("SELECT * FROM users WHERE accountID = :a");
				$q1->execute(array('a' => $u));
				$user = $q1->fetch(PDO::FETCH_ASSOC);

				echo "1:".$user["userName"].":2:".$user["userID"].":9:".$user["icon"].":10:".$user["pColor"].":11:".$user["sColor"].":14:".$user["iconType"].":15:".$user["special"].":16:".$user["accountID"].":18:".$user["new"].":41:".$user["new"]."|";
			}
			break;
		
		default:
			$q = $db->prepare("SELECT * FROM blocked WHERE accountID = :a");
			$q->execute(array('a' => $accountID));
			
			if($q->rowCount() <= 0) exit("-2");

			$r = $q->fetchAll();

			for($i = 0; $i < count($r); $i++) {
				$u = $r[$i]["targetID"];
				$q1 = $db->prepare("SELECT * FROM users WHERE accountID = :a");
				$q1->execute(array('a' => $u));
				$user = $q1->fetch(PDO::FETCH_ASSOC);

				echo "1:".$user["userName"].":2:".$user["userID"].":9:".$user["icon"].":10:".$user["pColor"].":11:".$user["sColor"].":14:".$user["iconType"].":15:".$user["special"].":16:".$user["accountID"].":18:0:41:0|";
			}
			break;
	}
} else exit("-1");
?>