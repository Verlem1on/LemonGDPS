<?
require "lib.php";
require "gjValues.php";
include "connection.php";

tryKillAccs();

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$comment = sqlTrim($_POST["comment"]);
$levelID = sqlTrim($_POST["levelID"]);
$percent = $_POST["percent"];

if (!checkAct($accountID)) exit("-1");

if(checkGJP($gjp, $accountID)) {
	if (checkLimit($accountID, 'comment')) exit("-1");
	changeTime($accountID, 'comment');
	increaseValue($accountID, 'comment');
	tryKillValues($accountID, 'comment');
	$q = $db->prepare("SELECT * FROM users WHERE accountID = :a");
	$q->execute(array('a' => $accountID));
	$r1 = $q->fetch(PDO::FETCH_ASSOC);

	if(disabled($accountID)) exit("-10");

	$c = base64_decode($comment);

	if($c == "#fame") {
		if(!checkAdmin($accountID)) exit("-1");
		$q = $db->prepare("UPDATE levels SET fame = 1 WHERE levelID = :l");
		$q->execute(array('l' => $levelID));
		exit("-1");
	} else if($c == "#unfame") {
		if(!checkAdmin($accountID)) exit("-1");
		$q = $db->prepare("UPDATE levels SET fame = 0 WHERE levelID = :l");
		$q->execute(array('l' => $levelID));
		exit("-1");
	} else if($c == "#epic") {
		if(!checkAdmin($accountID)) exit("-1");
		$q = $db->prepare("UPDATE levels SET epic = 1 WHERE levelID = :l");
		$q->execute(array('l' => $levelID));
		exit("-1");
	} else if($c == "#unepic") {
		if(!checkAdmin($accountID)) exit("-1");
		$q = $db->prepare("UPDATE levels SET epic = 0 WHERE levelID = :l");
		$q->execute(array('l' => $levelID));
		exit("-1");
	} else if($c == "#unrate") {
		if(!checkAdmin($accountID)) exit("-1");
		$q = $db->prepare("UPDATE levels SET epic = 0, fame = 0, featured = 0, demon = 0, demonType = 0, auto = 0, diff = 0, stars = 0, verifiedCoins = 0 WHERE levelID = :l");
		$q->execute(array('l' => $levelID));
		exit("-1");
	} else if ($c == "#rmsug") {
		if(!checkAdmin($accountID)) exit("-1");
		$q = $db->prepare("DELETE FROM levelRatings WHERE levelID = :l");
		$q->execute(array('l' => $levelID));
		exit("-1");
	}

	$q = $db->prepare("INSERT INTO comments (userID, accountID, accountComment, uploadTime, comment, levelID) VALUES (:u, :a, '0', :t, :c, :l)");
	$q->execute(array('u' => $r1["userID"], 'a' => $accountID, 't' => time(), 'c' => $comment, 'l' => $levelID));

	if($percent != "") {
		$q = $db->prepare("SELECT * FROM percentageInfo WHERE levelID = :l AND userID = :u");
		$q->execute(array('l' => $levelID, 'u' => $r1["userID"]));

		if($q->rowCount() > 0) {
			$q = $db->prepare("UPDATE percentageInfo SET percent = :p, updateTime = :u WHERE levelID = :l AND userID = :u");
			$q->execute(array('l' => $levelID, 'u' => $r1["userID"], 'p' => $percent, 't' => time()));
		} else {
			$q = $db->prepare("INSERT INTO percentageInfo (percent, levelID, userID, updateTime) VALUES (:p, :l, :u, :t)");
			$q->execute(array('l' => $levelID, 'u' => $r1["userID"], 'p' => $percent, 't' => time()));
		}
	}
	exit("1");
} else exit("-1");
?>
