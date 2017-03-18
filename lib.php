<?php

function checkGJP($gjp, $accountID) {
	include "connection.php";
	require "gjValues.php";
	$pwd = sha1(decodeGJP($gjp) . "ThUj31rsRRf");

	$q = $db->prepare("SELECT * FROM accounts WHERE accountID = :a");
	$q->execute([':a' => $accountID]);
	$r = $q->fetch(PDO::FETCH_ASSOC);
	if($pwd == $r["password"]) {
		return true;
	} else {
		return false;
	}
}

function checkUDID($udid, $accountID) {
	include "connection.php";
	$q = $db->prepare("SELECT * FROM users WHERE udid = :a AND accountID = :b");
	$q->execute([':a' => $udid, ':b' => $accountID]);
	return $q->rowCount() > 0 ? true : false;
}

class Anticheat {
	function Process($stars, $coins, $userCoins, $demons) {
		include 'connection.php';

		$q = $db->prepare("SELECT * FROM levels");
		$q->execute();
		$levels = $q->fetchAll();

		$q = $db->prepare("SELECT * FROM mappacks");
		$q->execute();
		$mp = $q->fetchAll();

		$maxStars = 187;
		$maxCoins = 63;
		$maxUC = 0;
		$maxDemons = 3;

		for($i = 0; $i < count($levels); $i++) {
			$level = $levels[$i];
			$maxStars += $level["stars"];
			$maxDemons += $level["demon"];
			if($level["verifiedCoins"] == "1") {
				$maxUC += $level["coins"];
			}
		}

		for($i = 0; $i < count($mp); $i++) {
			$m = $mp[$i];
			$maxStars += $m["stars"];
			$maxCoins += $m["coins"];
		}

		if($stars > $maxStars || $coins > $maxCoins || $userCoins > $maxUC || $demons > $maxDemons) return true;
		else return false;
	}

	function Dump() {
		include 'connection.php';

		$q = $db->prepare("SELECT * FROM levels");
		$q->execute();
		$levels = $q->fetchAll();

		$q = $db->prepare("SELECT * FROM mappacks");
		$q->execute();
		$mp = $q->fetchAll();

		$maxStars = 187;
		$maxCoins = 63;
		$maxUC = 0;
		$maxDemons = 3;

		for($i = 0; $i < count($levels); $i++) {
			$level = $levels[$i];
			$maxStars += $level["stars"];
			$maxDemons += $level["demon"];
			if($level["verifiedCoins"] == "1") {
				$maxUC += $level["coins"];
			}
		}

		for($i = 0; $i < count($mp); $i++) {
			$m = $mp[$i];
			$maxStars += $m["stars"];
			$maxCoins += $m["coins"];
		}

		echo 'Stars: ' . $maxStars . '; Coins: ' . $maxCoins . '; User coins: ' . $maxUC . '; Demons: ' . $maxDemons;
	}
}

function checkAdmin($accountID) {
	include "connection.php";
	$q = $db->prepare("SELECT * FROM accounts WHERE accountID = :a");
	$q->execute(array('a' => $accountID));
	$r = $q->fetch(PDO::FETCH_ASSOC);

	return $r['admin'] != 0 ? true : false;
}

function deleteSuggestion($levelID) {
	include "connection.php";

	$q = $db->prepare("DELETE FROM levelRatings WHERE levelID = :l");
	$q->execute(array('l' => $levelID));
}

function addSuggestion($accountID, $stars, $featured, $levelID, $diff, $isAutoRating, $isDemonRating, $vCoins, $demonType = 0, $isDemon = 0) {
	include "connection.php";

	file_put_contents('sug.txt', "$accountID $stars $featured $levelID $diff $isAutoRating $isDemonRating $vCoins $demonType $isDemon");

	if ($isDemon != 0) {
		$q = $db->prepare("SELECT * FROM levelRatings WHERE levelID = ?");
		$q->execute(array($levelID));

		if ($q->rowCount() > 0) {
			$q = $db->prepare("UPDATE levelRatings SET demonType = :d, byMod = :a WHERE levelID = :l");
			$q->execute(array('l' => $levelID, 'd' => $demonType, 'a' => $accountID));
		} else {
			$q = $db->prepare("INSERT INTO levelRatings (levelID, stars, demonType, byMod, demon) VALUES (:l, :s, :d, :a, :dem)");
			$q->execute(array('l' => $levelID, 's' => $stars, 'd' => $demonType, 1, 'a' => $accountID));
		}
	} else {
		$q = $db->prepare("SELECT * FROM levelRatings WHERE levelID = ?");
		$q->execute(array($levelID));

		if ($q->rowCount() > 0) {
			$q = $db->prepare("UPDATE levelRatings SET stars = :s, featured = :f, byMod = :a, diff = :d, auto = :au, demon = :dem WHERE levelID = :l");
			$q->execute(array('l' => $levelID, 's' => $stars, 'f' => $featured, 'a' => $accountID, 'd' => $diff, 'au' => $isAutoRating, 'dem' => $isDemonRating));
		} else {
			$q = $db->prepare("INSERT INTO levelRatings (levelID, stars, featured, diff, vCoins, byMod, auto, demon) VALUES (:l, :s, :d, :di, :v, :ac, :a, :dem)");
			$q->execute(array('l' => $levelID, 's' => $stars, 'd' => $featured, 'di' => $diff, 'v' => $vCoins, 'a' => $isAutoRating, 'dem' => $isDemonRating, 'ac' => $accountID));
		}
	}
}

function addContition($conditions, $condition, $keyword = 'AND') {
	if ($conditions != "")
		$conditions = " " . $condition;
	else
		$conditions .= " $keyword " . $conditions;

	return $conditions;
}

function getLevelsDiffBuilder($levelID) {
	include "connection.php";

	# 0 = :8:
	# 1 = :9:
	# 2 = :17:
	# 3 = :25:

	$q = $db->prepare("SELECT * FROM levels WHERE levelID = :l");
	$q->execute(array('l' => $levelID));
	$r = $q->fetch(PDO::FETCH_ASSOC);

	$diff = array();

	if ($r["demon"] != 0) {
		switch ($r["demonType"]) {
			case '6':
				$diff[0] = 5;
				$diff[1] = 50;
				$diff[2] = 0;
				$diff[3] = 0;
				break;

			case '4':
					$diff[0] = 6;
					$diff[1] = 50;
					$diff[2] = 0;
					$diff[3] = 0;
					break;

			case '3':
					$diff[0] = 7;
					$diff[1] = 50;
					$diff[2] = 0;
					$diff[3] = 0;
					break;

			case '2':
					$diff[0] = 8;
					$diff[1] = 50;
					$diff[2] = 0;
					$diff[3] = 0;
					break;

			case '5':
						$diff[0] = 7;
						$diff[1] = 60;
						$diff[2] = 0;
						$diff[3] = 0;
						break;

			default:
				$diff[0] = 10;
				$diff[1] = 50;
				$diff[2] = 1;
				$diff[3] = 0;
				break;
		}
	} else {
		$diff[0] = 10;
		$diff[1] = $r["diff"];
		$diff[2] = 0;
		$diff[3] = $r["auto"];
	}

	return $diff;
}

function makeDemon($demonFilter) {
	switch ($demonFilter) {
		case '1':
			return 3;

		case '2':
			return 4;

		case '3':
			return 0;

		case '4':
			return 5;

		case '5':
			return 6;
	}
}

function tryKillAccs() {
	include "connection.php";

	$q = $db->prepare("SELECT * FROM accounts WHERE actSent != 1");
	$q->execute();
	$r = $q->fetchAll();

	foreach ($r as $a) {
		if (time() - $a["accDate"] >= 3600) {
			$q = $db->prepare("DELETE FROM accounts WHERE accountID = :a AND actSent != 1");
			$q->execute(array('a' => $a["accountID"]));
		}
	}
}

function checkAct($accountID) {
	include "connection.php";

	$q = $db->prepare("SELECT * FROM accounts WHERE accountID = :a");
	$q->execute(array('a' => $accountID));
	$r = $q->fetch(PDO::FETCH_ASSOC);

	if ($r["actSent"] != 0) return true; else return false;
}

function changeTime($accountID, $type) {
	include 'connection.php';

	switch ($type) {
		case 'level':
			$q = $db->prepare("UPDATE accounts SET lastLevelTime = :t WHERE accountID = :a");
			$q->execute(array('a' => $accountID, 't' => time()));
			break;

		case 'comment':
			$q = $db->prepare("UPDATE accounts SET lastCommentTime = :t WHERE accountID = :a");
			$q->execute(array('a' => $accountID, 't' => time()));
			break;

		case 'accComment':
			$q = $db->prepare("UPDATE accounts SET lastAccTime = :t WHERE accountID = :a");
			$q->execute(array('a' => $accountID, 't' => time()));
			break;

		case 'message':
			$q = $db->prepare("UPDATE accounts SET lastMessageSent = :t WHERE accountID = :a");
			$q->execute(array('a' => $accountID, 't' => time()));
			break;
	}
}

function tryKillValues($accountID, $type) {
	include 'connection.php';

	switch ($type) {
		case 'level':
			$q = $db->prepare("SELECT * FROM accounts WHERE accountID = :a");
			$q->execute(array('a' => $accountID));
			$r = $q->fetch(PDO::FETCH_ASSOC);

			if ($r["levelsMade"] >= 15 and (time() - $r["lastLevelTime"]) >= 86400) {
				$q = $db->prepare("UPDATE accounts SET levelsMade = 0 WHERE accountID = :a");
				$q->execute(array('a' => $accountID));
			}

			break;

		case 'comment':
			$q = $db->prepare("SELECT * FROM accounts WHERE accountID = :a");
			$q->execute(array('a' => $accountID));
			$r = $q->fetch(PDO::FETCH_ASSOC);

			if ($r["commentsSent"] >= 900 and (time() - $r["lastCommentTime"]) >= 86400) {
				$q = $db->prepare("UPDATE accounts SET commentsSent = 0 WHERE accountID = :a");
				$q->execute(array('a' => $accountID));
			}

			break;

		case 'accComment':
			$q = $db->prepare("SELECT * FROM accounts WHERE accountID = :a");
			$q->execute(array('a' => $accountID));
			$r = $q->fetch(PDO::FETCH_ASSOC);

			if ($r["accSent"] >= 100 and (time() - $r["lastAccTime"]) >= 86400) {
				$q = $db->prepare("UPDATE accounts SET accSent = 0 WHERE accountID = :a");
				$q->execute(array('a' => $accountID));
			}

			break;

		case 'message':
			$q = $db->prepare("SELECT * FROM accounts WHERE accountID = :a");
			$q->execute(array('a' => $accountID));
			$r = $q->fetch(PDO::FETCH_ASSOC);

			if ($r["messageSent"] >= 5000 and (time() - $r["lastMessageSent"]) >= 86400) {
				$q = $db->prepare("UPDATE accounts SET messageSent = 0 WHERE accountID = :a");
				$q->execute(array('a' => $accountID));
			}

			break;
	}
}

function updateCP() {
	include "connection.php";
	$query = $db->prepare("SELECT * FROM users");
	$query->execute();
	$result = $query->fetchAll();

	foreach($result as $user){
		$query2 = $db->prepare("SELECT * FROM levels WHERE userID = '".$user["userID"]."' AND stars != 0");
		$query2->execute();
		$creatorpoints = $query2->rowCount();

		$query3 = $db->prepare("SELECT * FROM levels WHERE userID = '".$user["userID"]."' AND featured != 0");
		$query3->execute();
		$creatorpoints = $creatorpoints + $query3->rowCount();

        $query4 = $db->prepare("SELECT * FROM levels WHERE userID = '".$user["userID"]."' AND epic != 0");
        $query4->execute();
        $creatorpoints = $creatorpoints + $query4->rowCount();

		$query4 = $db->prepare("UPDATE users SET cp='$creatorpoints' WHERE userID='".$user["userID"]."'");
		$query4->execute();
	}
}

function increaseValue($accountID, $type) {
	include 'connection.php';

	switch ($type) {
		case 'level':
			$q = $db->prepare("UPDATE accounts SET levelsMade = levelsMade + 1 WHERE accountID = :a");
			$q->execute(array('a' => $accountID));
			break;

		case 'comment':
			$q = $db->prepare("UPDATE accounts SET commentsSent = commentsSent + 1 WHERE accountID = :a");
			$q->execute(array('a' => $accountID));
			break;

		case 'accComment':
			$q = $db->prepare("UPDATE accounts SET accSent = accSent + 1 WHERE accountID = :a");
			$q->execute(array('a' => $accountID));
			break;

		case 'message':
			$q = $db->prepare("UPDATE accounts SET messageSent = messageSent + 1 WHERE accountID = :a");
			$q->execute(array('a' => $accountID));
			break;
	}
}

function checkLimit($accountID, $limitType) {
	include 'connection.php';

	switch ($limitType) {
		case 'level':
			$q = $db->prepare("SELECT * FROM accounts WHERE accountID = :a");
			$q->execute(array('a' => $accountID));
			$r = $q->fetch(PDO::FETCH_ASSOC);

			if ($r["levelsMade"] >= 15 and (time() - $r["lastLevelTime"]) <= 86400) return true; else return false;
			break;

		case 'comment':
			$q = $db->prepare("SELECT * FROM accounts WHERE accountID = :a");
			$q->execute(array('a' => $accountID));
			$r = $q->fetch(PDO::FETCH_ASSOC);

			if ($r["commentsSent"] >= 900 and (time() - $r["lastCommentTime"]) <= 86400) return true; else return false;
			break;

		case 'accComment':
				$q = $db->prepare("SELECT * FROM accounts WHERE accountID = :a");
				$q->execute(array('a' => $accountID));
				$r = $q->fetch(PDO::FETCH_ASSOC);

				if ($r["accSent"] >= 100 and (time() - $r["lastAccTime"]) <= 86400) return true; else return false;
				break;

		case 'message':
					$q = $db->prepare("SELECT * FROM accounts WHERE accountID = :a");
					$q->execute(array('a' => $accountID));
					$r = $q->fetch(PDO::FETCH_ASSOC);

					if ($r["messageSent"] >= 500 and (time() - $r["lastMessageSent"]) <= 86400) return true; else return false;
					break;
	}
}

function sqlTrim($data) {
	return str_replace(array("'", "(", ")", "~", ":", "|", "#"), "", htmlspecialchars($data, ENT_QUOTES));
}

function makeTime($timestamp) {
$ts = $timestamp;
$cts = time();
$str = "";
$result = $cts-$ts;
if ($result < 31556952) {
if ($result < 2629746) {
if ($result < 86400) {
if ($result < 3600) {
if ($result < 60) {
$n = $result/1;
if ($n == 1){
$str = " second";
}else{
$str = " seconds";
}
$final = $n.$str;
}else{
 $n = floor($result/60);
if ($n == 1){
$str = " minute";
  }else{
  $str = " minutes";
}
$final = $n.$str;
 }
            }else{
            $n = floor($result/3660);
            if ($n == 1){
                    $str = " hour";
                    }else{
                    $str = " hours";
                    }
                    $final = $n.$str;
            }
        }else{
        $n = floor($result/86400);
        if ($n == 1){
                    $str = " day";
                    }else{
                    $str = " days";
                    }
                    $final = $n.$str;
        }
    }else{
    $n = floor($result/2629746);
    if ($n == 1){
                    $str = " month";
                    }else{
                    $str = " months";
                    }
                    $final = $n.$str;
    }
}else{
$n = floor($result/31556952);
if ($n == 1){
                    $str = " year";
                    }else{
                    $str = " years";
                    }
                    $final = $n.$str;
}
return $final;
}

function calcTop($accountID) {
	include "connection.php";
	$q = $db->prepare("SELECT * FROM users ORDER BY stars DESC");
	$q->execute();
	$r = $q->fetchAll();

	$bannedRemover = 0;

	for($i = 0; $i < count($r); $i++) {
		$user = $r[$i];

        $t = 1 + $i - $bannedRemover;

		if($user["accountID"] == $accountID) {
            if (isUserGlobalBanned($user['accountID']))
                return 0;
			return $t;
		} else {
			if (isUserGlobalBanned($user['accountID']))
				$bannedRemover += 1;
		}
	}
}

function newFriends($accountID) {
	include "connection.php";
	$q = $db->prepare("SELECT * FROM friends WHERE accountID = ? AND new = 1");
	$q->execute(array($accountID));
	$r = $q->fetchAll();
	return count($r);
}

function newRequests($accountID) {
	include "connection.php";
	$q = $db->prepare("SELECT * FROM frRequests WHERE `read` = '0' AND targetID = ?");
	$q->execute(array($accountID));
	$r = $q->fetchAll();
	return count($r);
}

function newMessages($accountID) {
	include "connection.php";
	$q = $db->prepare("SELECT * FROM messages WHERE `read` = '0' AND targetID = ?");
	$q->execute(array($accountID));
	$r = $q->fetchAll();
	return count($r);
}

function friendMessageAllowed($accountID) {
	include "connection.php";

	$q = $db->prepare("SELECT * FROM accounts WHERE accountID = :a");
	$q->execute([':a' => $accountID]);

	$r = $q->fetch(2);

	return $r['msgAllowed'] == 1 ? true : false;
}

function isUserGlobalBanned($accountID) {
	include "connection.php";

	$q = $db->prepare("SELECT * FROM accounts WHERE accountID = :a");
	$q->execute([':a' => $accountID]);

	$r = $q->fetch(2);

	return $r['banned'] != '0' ? true : false;
}

function friendStatus($a, $b) {
	include "connection.php";
	$q = $db->prepare("SELECT * FROM friends WHERE accountID = :a AND targetID = :b");
	$q->execute([':a' => $a, ':b' => $b]);
	if($q->rowCount() > 0) {
		return 1;
	}
	$q = $db->prepare("SELECT * FROM frRequests WHERE accountID = :a AND targetID = :b");
	$q->execute([':a' => $a, ':b' => $b]);
	if($q->rowCount() > 0) {
		return 4;
	}
	$q = $db->prepare("SELECT * FROM frRequests WHERE accountID = :b AND targetID = :a");
	$q->execute([':a' => $a, ':b' => $b]);
	if($q->rowCount() > 0) {
		return 3;
	}
	return 0;
}

function canWriteTo($accountID) {
	include "connection.php";
	$q = $db->prepare("SELECT * FROM accounts WHERE accountID = :a");
	$q->execute([':a' => $accountID]);
	$r = $q->fetch(PDO::FETCH_ASSOC);
	if($r["msgAllowed"] != "0") return false; else return true;
}

function isMod($accountID) {
	include "connection.php";
	$q = $db->prepare("SELECT * FROM accounts WHERE accountID = :a");
	$q->execute([':a' => $accountID]);
	$r = $q->fetch(PDO::FETCH_ASSOC);
	if($r["mod"] != "0") return false; else return true;
}

function messageStatus($accountID) {
	include "connection.php";
	$q = $db->prepare("SELECT * FROM accounts WHERE accountID = :a");
	$q->execute([':a' => $accountID]);
	$r = $q->fetch(PDO::FETCH_ASSOC);
	return $r["msgAllowed"];
}

function disabled($a) {
	include "connection.php";
	$q = $db->prepare("SELECT * FROM accounts WHERE accountID = :a");
	$q->execute([':a' => $a]);
	$r = $q->fetch(PDO::FETCH_ASSOC);
	if($r["disabled"] == "0") return false; else return true;
}

function maintenance() {
	include "connection.php";
	$q = $db->prepare("SELECT * FROM server");
	$q->execute();
	$r = $q->fetch(2);

	if ($r['maintenance'] != '0') return true; else return false;
}

function canAddToFriends($accountID) {
	include "connection.php";

	$q = $db->prepare("SELECT * FROM accounts WHERE accountID = :a");
	$q->execute([':a' => $accountID]);
	$r = $q->fetch(2);

	return $r['frAllowed'] != 0 ? false : true;
}
?>
