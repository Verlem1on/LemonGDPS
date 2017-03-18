<?
require "lib.php";
include "connection.php";

$percent = $_POST["percent"];
$accountID = $_POST["accountID"];
$gjp = $_POST["gjp"];
$levelID = $_POST["levelID"];

if(!checkGJP($gjp, $accountID)) exit("-1");
if (!checkAct($accountID)) exit("-1");

$q = $db->prepare("SELECT * FROM users WHERE accountID = :a");
$q->execute(array('a' => $accountID));
$r = $q->fetch(PDO::FETCH_ASSOC);

$q2 = $db->prepare("SELECT * FROM percentageInfo WHERE levelID = :l AND userID = :u");
$q2->execute(array('l' => $levelID, 'u' => $r["userID"]));

if($q2->rowCount() > 0) {
	$q1 = $db->prepare("UPDATE percentageInfo SET percent = :p, updateTime = :t WHERE levelID = :l AND userID = :u");
	$q1->execute(array('l' => $levelID, 'u' => $r["userID"], 'p' => $percent, 't' => time()));
} else {
	$q1 = $db->prepare("INSERT INTO percentageInfo (percent, levelID, userID, updateTime) VALUES (:p, :l, :u, :t)");
	$q1->execute(array('l' => $levelID, 'u' => $r["userID"], 'p' => $percent, 't' => time()));
}

$q = $db->prepare("SELECT * FROM percentageInfo WHERE levelID = :l ORDER BY percent DESC");
$q->execute(array('l' => $levelID));

$tmp = $q->fetchAll();
$top = 1;

foreach ($tmp as $a) {
	$q = $db->prepare("SELECT * FROM users WHERE userID = :u");
	$q->execute(array('u' => $a["userID"]));
	$r = $q->fetch(PDO::FETCH_ASSOC);

	if ($a["percent"] == 0) continue;

	echo "1:".$r["userName"].":2:".$a["userID"].":9:".$r["shareIcon"].":10:".$r["pColor"].":11:".$r["sColor"].":14:".$r["iconType"].":15:".$r["special"].":16:".$r["accountID"].":3:".$a["percent"].":6:".$top.":42:".makeTime($a["updateTime"])."|";
	$top++;
}
?>
