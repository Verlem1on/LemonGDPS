<?php
include "connection.php";
require_once('lib.php');
ini_set('memory_limit', '-1');


$usersString = "";
$songsString  = "";
$type = htmlspecialchars($_POST["type"],ENT_QUOTES);
$str = htmlspecialchars($_POST["str"]);
$accountID = htmlspecialchars($_POST["accountID"]);
$page = htmlspecialchars($_POST["page"]);
$totLevel = 0;
$querytxt = "";
$diff = htmlspecialchars($_POST["diff"]);
$star = htmlspecialchars($_POST["star"]);
$noStar = htmlspecialchars($_POST["noStar"]);
$featured = htmlspecialchars($_POST["featured"]);
$len = htmlspecialchars($_POST["len"]);
$twoPlayer = htmlspecialchars($_POST["twoPlayer"]);
$conditions = "";
$followed = htmlspecialchars($_POST["followed"]);
$song = htmlspecialchars($_POST["song"]);
$epic = $_POST["epic"];
$demonFilter = $_POST["demonFilter"];
$gauntlet = $_POST["gauntlet"];

if ($gauntlet != "") {
	$q = $db->prepare("SELECT * FROM gauntlets WHERE ID = :i");
	$q->execute(array('i' => $gauntlet));
	$r = $q->fetch(PDO::FETCH_ASSOC);

	$lvlsarray = explode(',', $r["levels"]);
	$users = "";
$i = 0;
foreach ($lvlsarray as $level) {
		$q = $db->prepare("SELECT * FROM levels WHERE levelID = :l");
		$q->execute(array('l' => $level));
		$level1 = $q->fetch(PDO::FETCH_ASSOC);
		echo "1:".$level1["levelID"].":2:".$level1["name"].":5:".$level1["version"].":6:".$level1["userID"].":8:10:9:".$level1["diff"].":10:".$level1["downloads"].":12:".$level1["song"].":13:".$level1["game"].":14:".$level1["likes"].":17:".$level1["demon"].":43:".$result["demonType"].":25:".$level1["auto"].":18:".$level1["stars"].":19:".$level1["featured"].":3:".$level1["desc"].":15:".$level1["length"].":30:".$level1["original"].":31:0:37:".$level1["coins"].":38:".$level1["verifiedCoins"].":39:".$level1["requestedStars"].":35:".$level1["songID"].":42:".$level1["epic"].":45:0:46:1:47:2:44:$gauntlet";
		$q = $db->prepare("SELECT * FROM users WHERE userID = :u");
		$q->execute(array('u' => $level1["userID"]));
		$r1 = $q->fetch(PDO::FETCH_ASSOC);
		$users .= $r1["userID"] . ":" . $r1["userName"] . ":" . $r1["accountID"];
		if ($i < 4) { echo "|"; $users .= "|"; }
		if ($i == 4) break;
$i++;
	}
	exit("#$users##".count($lvlsarray).":0:10#" . genMulti($r["levels"]));
}

if($diff != "-"){
	$txt = "";
	if($diff == -1 or $diff == -2 or $diff == -3){
		switch($diff){
			case -1:
				$txt = $txt." diff = '0' ";
				break;

			case -2;
				$txt = $txt." demon = 1";
				break;

			case -3;
				$txt = $txt." auto = 1";
				break;
		}
	}else{
		$temp = split(",", $diff);

		for($k = 0; $k < count($temp); $k++){
			if($k != 0){
				$txt = $txt." or ";
			}

			$txt = $txt."diff = '".($temp[$k]*10)."'";
		}

	}
	$conditions = $conditions." ".$txt;
}

if($demonFilter != "") {
	if ($diff == "-2") {
		$demonFilter = makeDemon($demonFilter);
		if($conditions != "")
			$conditions = $conditions." and demonType = '$demonFilter'";
		else{
			$conditions = " demonType = '$demonFilter'";
		}
	}
}

if($song != ""){
	if(htmlspecialchars($_POST["customSong"]) == 1){
		if($conditions != "")
			$conditions = $conditions." and songID = '".($song)."'";
		else{
			$conditions = " songID = '".($song)."'";
		}
	}else{
		if($conditions != "")
			$conditions = $conditions." and song = '".($song-1)."' and songID = 0";
		else{
			$conditions = " song = '".($song-1)."' and songID = 0";
		}
	}

}



if($star != ""){
	if($conditions != "")
		$conditions = $conditions." and stars != '0'";
	else{
		$conditions = " stars != '0'";
	}
}

if($noStar != ""){
	if($conditions != "")
		$conditions = $conditions." and stars < '1'";
	else{
		$conditions = " stars < '1'";
	}
}

if($featured != "0"){
	if($conditions != "")
		$conditions = $conditions." and featured != '0'";
	else{
		$conditions = " featured != '0'";
	}
}

if($epic == "1") {
	if($conditions != "")
		$conditions = $conditions." and epic != '0'";
	else{
		$conditions = " epic != '0'";
	}
}

if($twoPlayer != "0"){
	if($conditions != "")
		$conditions = $conditions." and twoPlayer != '0'";
	else{
		$conditions = " twoPlayer != '0'";
	}
}

if($len != "-"){
	$txt = "";
	$temp = split(",", $len);

	for($k = 0; $k < count($temp); $k++){
		if($k != 0){
			$txt = $txt." or ";
		}

		$txt = $txt."length = '".($temp[$k])."'";
	}
	if($conditions != "")
		$conditions = $conditions." and ".$txt."";
	else{
		$conditions = "".$txt;
	}
}

$isGauntlet = false;
$gauntletLevels = "";

if ($gauntlet != "") {
	$isGauntlet = true;

	$q = $db->prepare("SELECT * FROM gauntlets WHERE ID = :i");
	$q->execute(array('i' => $gauntlet));
	$r = $q->fetch(PDO::FETCH_ASSOC);
	$gauntletLevels = $r["levels"];
}

switch ($type){
	case 0:

		if(is_numeric($str)){
			if($conditions != ""){
				$querytxt = "SELECT * FROM levels  WHERE  levelID = '".$str."' ORDER BY likes DESC";
			}else{
				$querytxt = "SELECT * FROM levels  WHERE  levelID = '".$str."' ORDER BY likes DESC";
			}
		}else{
			if($conditions != ""){
				$querytxt = "SELECT * FROM levels WHERE name LIKE '".$str."%' and (".$conditions.") AND unlisted != '1' ORDER BY likes DESC";
			}else{
				$querytxt = "SELECT * FROM levels WHERE name LIKE '".$str."%' AND unlisted != '1' ORDER BY likes DESC";
			}
		}
		break;

	case 1:
		if($conditions != ""){
			$querytxt = "SELECT * FROM levels WHERE ".$conditions." AND unlisted != '1' ORDER BY downloads DESC";
		}else{
			$querytxt = "SELECT * FROM levels WHERE unlisted != '1' ORDER BY downloads DESC";
		}
		break;

	case 2:
		if($conditions != ""){
			$querytxt = "SELECT * FROM levels WHERE ".$conditions." AND unlisted != '1' ORDER BY likes DESC";
		}else{
			$querytxt = "SELECT * FROM levels WHERE unlisted != '1' ORDER BY likes DESC";
		}
		break;

	case 4:
		if($conditions != ""){
			$querytxt = "SELECT * FROM levels WHERE ".$conditions." AND unlisted != '1' ORDER BY levelID DESC";
		}else{
			$querytxt = "SELECT * FROM levels WHERE unlisted != '1' ORDER BY levelID DESC";
		}
		break;

	case 16:
		if($conditions != ""){
			$querytxt = "SELECT * FROM levels WHERE $conditions AND fame != '0' AND unlisted != '1' ORDER BY levelID DESC";
		}else{
			$querytxt = "SELECT * FROM levels WHERE fame != '0' AND unlisted != '1' ORDER BY levelID DESC";
		}
		break;

	case 5:
		$querytxt = "SELECT * FROM levels WHERE userID = '$str' AND unlisted != '1' ORDER BY levelID DESC";
		break;

	case 6:
		$querytxt = "SELECT * FROM `levels` WHERE featured AND unlisted != '1' ORDER BY levelID DESC";
		break;

	case 7:
		$querytxt = "SELECT * FROM levels WHERE objects > '4999' AND unlisted != '1' ORDER BY levelID DESC";
		break;

	case 11:
		$querytxt = "SELECT * FROM levels WHERE stars != '0' AND unlisted != '1' ORDER BY levelID DESC";
		break;
}

$lvls = "";

if ($type == 12) {
	$sArr = explode(',', $followed);

	$levels = array();
	$users = '';
	$userids = array();
	$lh = '';

	for ($i = 0; $i < count($sArr); $i++) {
		$q = $db->prepare("SELECT * FROM users WHERE accountID = :a");
		$q->execute(array('a' => $sArr[$i]));
		$r1 = $q->fetch(PDO::FETCH_ASSOC);
		$userids[$i] = $r1['userID'];
	}

	for ($i = 0; $i < count($userids); $i++) {
		$q = $db->prepare("SELECT * FROM levels WHERE userID = :u");
		$q->execute(array('u' => $userids[$i]));
		$levels[$i] = $q->fetch(PDO::FETCH_ASSOC);
	}

	for ($i = 0; $i < 10; $i++) {
		$level1 = $levels[$page*10+$i];

		if ($level1['levelID'] == '') break;

		echo "1:".$level1["levelID"].":2:".$level1["name"].":5:".$level1["version"].":6:".$level1["userID"].":8:10:9:".$level1["diff"].":10:".$level1["downloads"].":12:".$level1["song"].":13:".$level1["game"].":14:".$level1["likes"].":17:".$level1["demon"].":43:".$result["demonType"].":25:".$level1["auto"].":18:".$level1["stars"].":19:".$level1["featured"].":3:".$level1["desc"].":15:".$level1["length"].":30:".$level1["original"].":31:0:37:".$level1["coins"].":38:".$level1["verifiedCoins"].":39:".$level1["requestedStars"].":35:".$level1["songID"].":42:".$level1["epic"].":45:0:46:1:47:2";

		$lh .= $level1['levelID'];

		$q = $db->prepare("SELECT * FROM users WHERE userID = :u");
		$q->execute(array('u' => $level1['userID']));
		$r = $q->fetch(PDO::FETCH_ASSOC);

		$users .= $r['userID'] . ':' . $r['userName'] . ':' . $r['accountID'];

		if ($i < 10) { echo '|'; $users .= '|'; $lh .= ','; }
	}

	exit("#$users##" . count($levels) . ":$page:10#" . genMulti($lh));
}

if($type == 13){
	if ( checkAdmin($accountID) ) {
		$q = $db->prepare("SELECT * FROM levelRatings WHERE byMod != 0 ORDER BY ratingID DESC");
		$q->execute();

		$r = $q->fetchAll();
		# Well, I need to remake hash system XD

		$levelData = array(array());
		$hash = '';
		$users = '';

		$modAccIDs = array();

		for ($i = 0; $i < count($r); $i++) {
			$l = $r[$i];

			$levelData[$i]['levelID'] = $l['levelID'];
			$levelData[$i]['stars'] = $l['stars'];
			$levelData[$i]['vCoins'] = $l['vCoins'];
			$levelData[$i]['diff'] = $l['diff'];
			$levelData[$i]['auto'] = $l['auto'];
			$levelData[$i]['demon'] = $l['demon'];
			$levelData[$i]['featured'] = $l['featured'];
			$levelData[$i]['demonType'] = $l['demonType'];
			$modAccIDs[$i] = $l['byMod'];
		}

		$rmIDs = array();

		for ($i = 0; $i < 10; $i++) {
			$l = $levelData[$i + $page * 10];

			$q = $db->prepare("SELECT * FROM levels WHERE levelID = :l");
			$q->execute(array('l' => $levelData[$i + $page * 10]['levelID']));

			$level1 = $q->fetch(PDO::FETCH_ASSOC);

			if ($level1['levelID'] == '') {
				$rmIDs[$i] = $l['levelID'];
				$i++;
				continue;
			}

			if($i != 0) { echo "|"; $users .= "|"; }

			$hash .= $l['levelID'][0] . $l['levelID'][strlen($l['levelID']) - 1] . $l['stars'] . $l['vCoins'];

			echo "1:".$level1["levelID"].":2:".$level1["name"].":5:".$level1["version"].":6:".$level1["userID"].":8:10:9:".$l["diff"].":10:".$level1["downloads"].":12:".$level1["song"].":13:".$level1["game"].":14:".$level1["likes"].":17:".$l["demon"].":43:".$l["demonType"].":25:".$l["auto"].":18:".$l["stars"].":19:".$l["featured"].":3:".$level1["desc"].":15:".$level1["length"].":30:".$level1["original"].":31:0:37:".$level1["coins"].":38:".$l["vCoins"].":39:".$level1["requestedStars"].":35:".$level1["songID"].":42:".$level1["epic"].":45:0:46:1:47:2";

			$q = $db->prepare("SELECT * FROM users WHERE accountID = :i");
			$q->execute(array('i' => $modAccIDs[$i]));
			$r = $q->fetch(PDO::FETCH_ASSOC);

			$users .= $level1['userID'] . ':' . $r['userName'] . ':' . $r['accountID'];

			if ($levelData[$i+$page*10+1] == '') break;
		}

		foreach ($rmIDs as $ID) {
			$q = $db->prepare("DELETE FROM levelRatings WHERE levelID = :l");
			$q->execute([':l' => $ID]);
		}

		exit('#' . $users . '##' . count($levelData) . ':' . ($page*10) . ':10' . '#' . sha1($hash . 'xI25fpAapCQg'));
	}
}

if($type == 10){
	$lvlsarray = explode(',', $str);
	$users = "";
$i = 0;
foreach ($lvlsarray as $level) {
		$q = $db->prepare("SELECT * FROM levels WHERE levelID = :l");
		$q->execute(array('l' => $level));
		$level1 = $q->fetch(PDO::FETCH_ASSOC);
		echo "1:".$level1["levelID"].":2:".$level1["name"].":5:".$level1["version"].":6:".$level1["userID"].":8:10:9:".$level1["diff"].":10:".$level1["downloads"].":12:".$level1["song"].":13:".$level1["game"].":14:".$level1["likes"].":17:".$level1["demon"].":43:".$result["demonType"].":25:".$level1["auto"].":18:".$level1["stars"].":19:".$level1["featured"].":3:".$level1["desc"].":15:".$level1["length"].":30:".$level1["original"].":31:0:37:".$level1["coins"].":38:".$level1["verifiedCoins"].":39:".$level1["requestedStars"].":35:".$level1["songID"].":42:".$level1["epic"].":45:0:46:1:47:2";
		$q = $db->prepare("SELECT * FROM users WHERE userID = :u");
		$q->execute(array('u' => $level1["userID"]));
		$r1 = $q->fetch(PDO::FETCH_ASSOC);
		$users .= $r1["userID"] . ":" . $r1["userName"] . ":" . $r1["accountID"];
		if ($i < (count($lvlsarray) - 1)) { echo "|"; $users .= "|"; }
$i++;
	}
	exit("#$users##".count($lvlsarray).":0:10#" . genMulti($str));
}

if($type < 1337 and $type != 10){

	$query2 = $db->prepare($querytxt);
	$query2->execute();

	if ($query2->rowCount() > 0) {
		$result = $query2->fetchAll();
		for($k = 0; $k < 10 ; $k ++){
			$currentLevel = ($page*10)+$k;

			$level1 = $result[$currentLevel];

			if($currentLevel >= count($result)) break;

			if($k != 0) { echo "|"; $lvls .= ","; }
			$lvls .= $level1["levelID"];
			$diff = getLevelsDiffBuilder($level1["levelID"]);
			echo "1:".$level1["levelID"].":2:".$level1["name"].":5:".$level1["version"].":6:".$level1["userID"].":8:10:9:".$level1['diff'].":10:".$level1["downloads"].":12:".$level1["song"].":13:".$level1["game"].":14:".$level1["likes"].":17:".$level1['demon'].":43:".$level1["demonType"].":25:".$level1['auto'].":18:".$level1["stars"].":19:".$level1["featured"].":3:".$level1["desc"].":15:".$level1["length"].":30:".$level1["original"].":31:0:37:".$level1["coins"].":38:".$level1["verifiedCoins"].":39:".$level1["requestedStars"].":35:".$level1["songID"].":42:".$level1["epic"];;

			$id = $level1["userID"];
			$query = $db->prepare("SELECT * FROM users WHERE userID = :id");
			$query->execute([':id' => $id]);
			$res = $query->fetchAll();
			$user = $res[0];

			if($k == 0){
				$usersString = $usersString.$level1["userID"].":".$user["userName"].":".$user["accountID"];
			}else{
				$usersString = $usersString."|".$level1["userID"].":".$user["userName"].":".$user["accountID"];
			}
			$y = 0;
			/*
			if($level1["songID"] != 0){
				$id = $level1["userID"];
				$query = $db->prepare("SELECT * FROM songs WHERE levelID = '".$level1["levelID"]."'");
				$query->execute();
				$res = $query->fetchAll();
				$song = $res[0];
				if($y == 0){
					$songsString = $songsString.$song["songString"];
				}else{
					$songsString = $songsString.":".$song["songString"];
				}
			}*/
		}

		$totLevel = count($result);
		echo "#";
		echo $usersString;
		echo "#";
		echo "#";
		echo $totLevel.":".($page*10).":10";
	}
}

echo "#" . genMulti($lvls);

function genMulti($lvlsmultistring) {
	$lvlsarray = explode(",", $lvlsmultistring);
	include "connection.php";
	$hash = "";
	foreach($lvlsarray as $id){
		$query=$db->prepare("select * from levels where levelID = :i");
		$query->execute(array('i' => $id));
		$result2 = $query->fetchAll();
		$result = $result2[0];
		$hash = $hash . $result["levelID"][0].$result["levelID"][strlen($result["levelID"])-1].$result["stars"].$result["verifiedCoins"];
	}
	return sha1($hash . "xI25fpAapCQg");
}
?>
