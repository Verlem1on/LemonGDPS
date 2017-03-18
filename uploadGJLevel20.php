<?
include "connection.php";
require "lib.php";

tryKillAccs();

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$levelName = sqlTrim($_POST["levelName"]);
$levelID = sqlTrim($_POST["levelID"]);
$original = sqlTrim($_POST["original"]);
$levelString = sqlTrim($_POST["levelString"]);
$levelDesc = sqlTrim($_POST["levelDesc"]);
$levelInfo = sqlTrim($_POST["levelInfo"]);
$extraString = sqlTrim($_POST["extraString"]);
$songID = sqlTrim($_POST["songID"]);
$audioTrack = sqlTrim($_POST["audioTrack"]);
$twoPlayer = sqlTrim($_POST["twoPlayer"]);
$objects = sqlTrim($_POST["objects"]);
$gameVersion = sqlTrim($_POST["gameVersion"]);
$password = sqlTrim($_POST["password"]);
$coins = sqlTrim($_POST["coins"]);
$levelVersion = sqlTrim($_POST["levelVersion"]);
$levelLength = sqlTrim($_POST["levelLength"]);
$requestedStars = sqlTrim($_POST["requestedStars"]);

if(disabled($accountID)) exit("-1");
if (!checkAct($accountID)) exit("-1");

if(checkGJP($gjp, $accountID)) {
	$a = $db->prepare("SELECT * FROM users WHERE accountID = '$accountID'");
	$a->execute();
	$r = $a->fetch(PDO::FETCH_ASSOC);

	if($levelID != "0") {
		$q = $db->prepare("SELECT * FROM levels WHERE levelID = '$levelID'");
		$q->execute();
		if($q->rowCount() > 0) {
			$res = $q->fetch(PDO::FETCH_ASSOC);
			if($res["userID"] == $r["userID"]) {
				$q1 = $db->prepare("UPDATE levels SET string = '$levelString', version = '$levelVersion', length = '$levelLength', `desc` = '$levelDesc', coins = '$coins', requestedStars = '$requestedStars', objects = '$objects', twoPlayer = '$twoPlayer', songID = '$songID', song = '$audioTrack', extra = '$extraString', info = '$levelInfo', password = '$password', original = '$original', game = '$gameVersion', updateTime = '".time()."' WHERE levelID = '$levelID'");
				$q1->execute(array('u' => $unlisted));
				exit("$levelID");
			} else exit("-1");
		} else exit("-1");
	}

	$q = $db->prepare("INSERT INTO levels (name, userID, version, `desc`, coins, objects, twoPlayer, songID, song, string, extra, password, length, info, original, game, requestedStars, uploadTime, updateTime) VALUES ('$levelName', '".$r["userID"]."', '$levelVersion', '$levelDesc', '$coins', '$objects', '$twoPlayer', '$songID', '$audioTrack', '$levelString', '$extraString', '$password', '$levelLength', '$levelInfo', '$original', '$gameVersion', '$requestedStars', '".time()."', '".time()."')");
	$q->execute(array('u' => $unlisted));
	exit($db->lastInsertId());
} else {
	exit("-1");
}
?>
