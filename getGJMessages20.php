<?
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$page = sqlTrim($_POST["page"]);
$getSent = sqlTrim($_POST["getSent"]);

if(disabled($accountID)) exit("-1");

if(checkGJP($gjp, $accountID)) {
	switch ($getSent) {
		case '1':
			$q = $db->prepare("SELECT * FROM messages WHERE accountID = :a ORDER BY messageID DESC");
			$q->execute(array('a' => $accountID));
			$r = $q->fetchAll();
			$userString = "";

			if($q->rowCount() == 0) exit("-2");

			for($i = 0; $i < 10; $i++) {
				$m = $r[$page * 10 + $i];
				$a = $db->prepare("SELECT * FROM users WHERE accountID = '".$m["targetID"]."'");
				$a->execute();
				$u = $a->fetch(PDO::FETCH_ASSOC);

				echo "6:".$u["userName"].":3:".$u["userID"].":2:".$m["targetID"].":1:".$m["messageID"].":4:".$m["subject"].":8:1:9:0:7:".makeTime($m["uploadTime"]);
				$userString .= $u["userID"] . ":" . $u["userName"] . ":" . $u["accountID"];

				if($r[$page*10+$i+1]["messageID"] == "") break; else {
					$userString .= "|";
					echo "|";
				}
			}
			exit("#$userString#:0:50");
			break;
		
		default:
			$q = $db->prepare("SELECT * FROM messages WHERE targetID = :a ORDER BY messageID DESC");
			$q->execute(array('a' => $accountID));
			$r = $q->fetchAll();
			$userString = "";

			if($q->rowCount() == 0) exit("-2");

			for($i = 0; $i < 10; $i++) {
				$m = $r[$page * 10 + $i];
				$a = $db->prepare("SELECT * FROM users WHERE accountID = '".$m["accountID"]."'");
				$a->execute();
				$u = $a->fetch(PDO::FETCH_ASSOC);

				echo "6:".$u["userName"].":3:".$u["userID"].":2:".$m["accountID"].":1:".$m["messageID"].":4:".$m["subject"].":8:1:9:0:7:".makeTime($m["uploadTime"]);
				$userString .= $u["userID"] . ":" . $u["userName"] . ":" . $u["accountID"];

				if($r[$page*10+$i+1]["messageID"] == "") break; else {
					$userString .= "|";
					echo "|";
				}
			}
			exit("#$userString#:0:50");
			break;
	}
}
?>