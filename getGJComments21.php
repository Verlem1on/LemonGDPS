<?
include "connection.php";
require "lib.php";

$levelID = $_POST["levelID"];
$page = $_POST["page"];
$userID = $_POST["userID"];
$mode = $_POST["mode"];

updateCP();

if($mode == "0") {
	$q = $db->prepare("SELECT * FROM comments WHERE levelID = :l ORDER BY uploadTime DESC");
	$q->execute([':l' => $levelID]);
	$r = $q->fetchAll();

	if(count($r) <= 0) exit("#0:0:10");

	foreach ($r as $c) {
		if($c["commentID"] != "") {

			$q = $db->prepare("SELECT * FROM percentageInfo WHERE userID = :u AND levelID = :l");
			$q->execute(array('u' => $c["userID"], 'l' => $levelID));
			$r1 = $q->fetch(PDO::FETCH_ASSOC);
			$q1 = $db->prepare("SELECT * FROM users WHERE userID = :u");
			$q1->execute(array('u' => $c["userID"]));
			$user = $q1->fetch(PDO::FETCH_ASSOC);

			echo "2~".$c["comment"]."~3~".$c["userID"]."~4~".$c["likes"]."~7~0~10~".$r1["percent"]."~9~".makeTime($c["uploadTime"])."~6~".$c["commentID"].":1~".$user["userName"]."~9~".$user["shareIcon"]."~10~".$user["pColor"]."~11~".$user["sColor"]."~14~".$user["iconType"]."~15~".$user["special"]."~16~".$user["accountID"]."|";
		}

		if($i >= 10) break;
	}

	exit("#" . count($r) . ":$page:10");
} else {
	$q = $db->prepare("SELECT * FROM comments WHERE levelID = :l ORDER BY likes DESC");
	$q->execute([':l' => $levelID]);
	$r = $q->fetchAll();

	if(count($r) <= 0) exit("#0:0:10");

	foreach ($r as $c) {
		if($c["commentID"] != "") {

			$q = $db->prepare("SELECT * FROM percentageInfo WHERE userID = :u AND levelID = :l");
			$q->execute(array('u' => $c["userID"], 'l' => $levelID));
			$r = $q->fetch(PDO::FETCH_ASSOC);
			$q1 = $db->prepare("SELECT * FROM users WHERE userID = :u");
			$q1->execute(array('u' => $c["userID"]));
			$user = $q1->fetch(PDO::FETCH_ASSOC);

			echo "2~".$c["comment"]."~3~".$c["userID"]."~4~".$c["likes"]."~7~0~10~".$r["percent"]."~9~".makeTime($c["uploadTime"])."~6~".$c["commentID"].":1~".$user["userName"]."~9~".$user["icon"]."~10~".$user["pColor"]."~11~".$user["sColor"]."~14~".$user["iconType"]."~15~".$user["special"]."~16~".$user["accountID"]."|";
		}

		if($i >= 10) break;
	}

	exit("#" . count($r) . ":$page:10");
}
?>
