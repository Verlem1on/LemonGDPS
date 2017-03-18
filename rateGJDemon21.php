<?
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$rating = sqlTrim($_POST["rating"]);
$levelID = sqlTrim($_POST["levelID"]);
$mode = sqlTrim($_POST["mode"]);

if(disabled($accountID)) exit("-1");
if (!checkAct($accountID)) exit("-1");
if(!checkGJP($gjp, $accountID)) exit("-1");

if($mode == "1") {
	$q = $db->prepare("SELECT * FROM accounts WHERE accountID = :a");
	$q->execute(array('a' => $accountID));
	$r = $q->fetch(PDO::FETCH_ASSOC);

	if(!checkAdmin($accountID)) {
		if ($r['mod'] != '1') {
			exit('-1');
		}
	}

	unset($q);

	switch ($rating) {
		case '1':
			if (checkAdmin($accountID)) {
				$q = $db->prepare("UPDATE levels SET demonType = '3' WHERE levelID = :l");
				$q->execute(array('l' => $levelID));

				deleteSuggestion($levelID);
			} else {
				$q = $db->prepare("SELECT * FROM levelRatings WHERE levelID = ?");
				$q->execute(array($levelID));

				if ($q->rowCount() > 0) {
					$q = $db->prepare("UPDATE levelRatings SET demonType = 3, byMod = :a WHERE levelID = :l");
					$q->execute(array('l' => $levelID, 'a' => $accountID));
				} else {
					$q = $db->prepare("INSERT INTO levelRatings (levelID, stars, demonType, byMod, diff, demon) VALUES (:l, :s, :d, :a, 50, 1)");
					$q->execute(array('l' => $levelID, 's' => 10, 'd' => 3, 'a' => $accountID));
				}
			}
			exit("1");
			break;

		case '2':
			if (checkAdmin($accountID)) {
				$q = $db->prepare("UPDATE levels SET demonType = '4' WHERE levelID = :l");
				$q->execute(array('l' => $levelID));

				deleteSuggestion($levelID);
			} else {
				$q = $db->prepare("SELECT * FROM levelRatings WHERE levelID = ?");
				$q->execute(array($levelID));

				if ($q->rowCount() > 0) {
					$q = $db->prepare("UPDATE levelRatings SET demonType = 4, byMod = :a WHERE levelID = :l");
					$q->execute(array('l' => $levelID, 'a' => $accountID));
				} else {
					$q = $db->prepare("INSERT INTO levelRatings (levelID, stars, demonType, byMod, diff, demon) VALUES (:l, :s, :d, :a, 50, 1)");
					$q->execute(array('l' => $levelID, 's' => 10, 'd' => 4, 'a' => $accountID));
				}
			}
			exit("1");
			break;

		case '3':
			if (checkAdmin($accountID)) {
				$q = $db->prepare("UPDATE levels SET demonType = '0' WHERE levelID = :l");
				$q->execute(array('l' => $levelID));

				deleteSuggestion($levelID);
			} else {
				$q = $db->prepare("SELECT * FROM levelRatings WHERE levelID = ?");
				$q->execute(array($levelID));

				if ($q->rowCount() > 0) {
					$q = $db->prepare("UPDATE levelRatings SET demonType = 0, byMod = :a WHERE levelID = :l");
					$q->execute(array('l' => $levelID, 'a' => $accountID));
				} else {
					$q = $db->prepare("INSERT INTO levelRatings (levelID, stars, demonType, byMod, diff, demon) VALUES (:l, :s, :d, :a, 50, 1)");
					$q->execute(array('l' => $levelID, 's' => 10, 'd' => 0, 'a' => $accountID));
				}
			}
			exit("1");
			break;

		case '4':
			if (checkAdmin($accountID)) {
				$q = $db->prepare("UPDATE levels SET demonType = '5' WHERE levelID = :l");
				$q->execute(array('l' => $levelID));

				deleteSuggestion($levelID);
			} else {
				$q = $db->prepare("SELECT * FROM levelRatings WHERE levelID = ?");
				$q->execute(array($levelID));

				if ($q->rowCount() > 0) {
					$q = $db->prepare("UPDATE levelRatings SET demonType = 5, byMod = :a WHERE levelID = :l");
					$q->execute(array('l' => $levelID, 'a' => $accountID));
				} else {
					$q = $db->prepare("INSERT INTO levelRatings (levelID, stars, demonType, byMod, diff, demon) VALUES (:l, :s, :d, :a, 50, 1)");
					$q->execute(array('l' => $levelID, 's' => 10, 'd' => 5, 'a' => $accountID));
				}
			}
			exit("1");
			break;

		case '5':
			if (checkAdmin($accountID)) {
				$q = $db->prepare("UPDATE levels SET demonType = '6' WHERE levelID = :l");
				$q->execute(array('l' => $levelID));

				deleteSuggestion($levelID);
			} else {
				$q = $db->prepare("SELECT * FROM levelRatings WHERE levelID = ?");
				$q->execute(array($levelID));

				if ($q->rowCount() > 0) {
					$q = $db->prepare("UPDATE levelRatings SET demonType = 6, byMod = :a WHERE levelID = :l");
					$q->execute(array('l' => $levelID, 'a' => $accountID));
				} else {
					$q = $db->prepare("INSERT INTO levelRatings (levelID, stars, demonType, byMod, diff, demon) VALUES (:l, :s, :d, :a, 50, 1)");
					$q->execute(array('l' => $levelID, 's' => 10, 'd' => 6, 'a' => $accountID));
				}
			}
			exit("1");
			break;
	}
}
?>
