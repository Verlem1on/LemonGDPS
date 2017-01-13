<?
require "lib.php";
include "connection.php";

$levelID = sqlTrim($_POST["levelID"]);
$page = sqlTrim($_POST["page"]);
$p = $page * 10;

$q = $db->prepare("SELECT * FROM comments WHERE accountComment = '0' AND levelID = :l ORDER BY commentID DESC");
$q->execute(array('l' => $levelID));
$r = $q->fetchAll();

if(count($r) == 0) exit("#0:0:10");

$userString = "";

for($i = 0; $i < 10; $i++) {
	$c = $r[$p + $i];
	echo "2~".$c["comment"]."~3~".$c["userID"]."~4~".$c["likes"]."~5~0~7~0~9~".makeTime($c["uploadTime"])."~6~".$c["commentID"];
	$q = $db->prepare("SELECT * FROM users WHERE accountID = :a");
	$q->execute(array('a' => $c["accountID"]));
	$u = $q->fetch(PDO::FETCH_ASSOC);
	$userString .= $c["userID"] . ":" . $u["userName"] . ":" . $c["accountID"];

	if($r[$p + $i + 1]["commentID"] != "") {
		echo "|";
		$userString .= "|";
	} else break;
}

exit("#$userString#".count($r).":$page:10");
?>