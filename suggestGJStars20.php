<?
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$stars = sqlTrim($_POST["stars"]);
$featured = sqlTrim($_POST["feature"]);
$levelID = sqlTrim($_POST["levelID"]);

if(disabled($accountID)) exit("-1");
if (!checkAct($accountID)) exit("-1");

if(!checkGJP($gjp, $accountID)) exit("-1");
$q = $db->prepare("SELECT * FROM accounts WHERE accountID = :a");
$q->execute([':a' => $accountID]);
$r = $q->fetch(PDO::FETCH_ASSOC);

if(!checkAdmin($accountID)) {
	if ($r['mod'] != '1') {
		exit('-1');
	}
}

unset($q);

$q = $db->prepare("SELECT * FROM levels WHERE levelID = :l");
$q->execute(array('l' => $levelID));
$r = $q->fetch(PDO::FETCH_ASSOC);

if (checkAdmin($accountID)) {
	if ($r["length"] <= 1) {
		if ($stars >= 2) {
			switch ($stars) {
				case '1':
					$q = $db->prepare("UPDATE levels SET diff = '50', auto = '1', demon = '0', stars = '1', featured = :f WHERE levelID = :l");
					$q->execute([':l' => $levelID, ':f' => $featured]);
          deleteSuggestion($levelID);
					exit("1");
					break;

				default:
					$q = $db->prepare("UPDATE levels SET diff = '10', auto = '0', demon = '0', stars = '2', featured = :f WHERE levelID = :l");
					$q->execute([':l' => $levelID, ':f' => $featured]);
          deleteSuggestion($levelID);
					exit("1");
					break;
			}
		}
	}

	switch ($stars) {
		case '1':
			$q = $db->prepare("UPDATE levels SET diff = '50', auto = '1', demon = '0', stars = :s, featured = :f WHERE levelID = :l");
			$q->execute([':l' => $levelID, ':f' => $featured, ':s' => $stars]);
			echo("1");
			break;

		case '2':
			$q = $db->prepare("UPDATE levels SET diff = '10', auto = '0', demon = '0', stars = :s, featured = :f WHERE levelID = :l");
			$q->execute([':l' => $levelID, ':f' => $featured, ':s' => $stars]);
			echo("1");
			break;

		case '3':
			$q = $db->prepare("UPDATE levels SET diff = '20', auto = '0', demon = '0', stars = :s, featured = :f WHERE levelID = :l");
			$q->execute([':l' => $levelID, ':f' => $featured, ':s' => $stars]);
			echo("1");
			break;

		case '4':
			$q = $db->prepare("UPDATE levels SET diff = '30', auto = '0', demon = '0', stars = :s, featured = :f WHERE levelID = :l");
			$q->execute([':l' => $levelID, ':f' => $featured, ':s' => $stars]);
			echo("1");
			break;

		case '5':
			$q = $db->prepare("UPDATE levels SET diff = '30', auto = '0', demon = '0', stars = :s, featured = :f WHERE levelID = :l");
			$q->execute([':l' => $levelID, ':f' => $featured, ':s' => $stars]);
			echo("1");
			break;

		case '6':
			$q = $db->prepare("UPDATE levels SET diff = '40', auto = '0', demon = '0', stars = :s, featured = :f WHERE levelID = :l");
			$q->execute([':l' => $levelID, ':f' => $featured, ':s' => $stars]);
			echo("1");
			break;

		case '7':
			$q = $db->prepare("UPDATE levels SET diff = '40', auto = '0', demon = '0', stars = :s, featured = :f WHERE levelID = :l");
			$q->execute([':l' => $levelID, ':f' => $featured, ':s' => $stars]);
			echo("1");
			break;

		case '8':
			$q = $db->prepare("UPDATE levels SET diff = '50', auto = '0', demon = '0', stars = :s, featured = :f WHERE levelID = :l");
			$q->execute([':l' => $levelID, ':f' => $featured, ':s' => $stars]);
			echo("1");
			break;

		case '9':
			$q = $db->prepare("UPDATE levels SET diff = '50', auto = '0', demon = '0', stars = :s, featured = :f WHERE levelID = :l");
			$q->execute([':l' => $levelID, ':f' => $featured, ':s' => $stars]);
			echo("1");
			break;

		case '10':
			$q = $db->prepare("UPDATE levels SET diff = '50', auto = '0', demon = '1', stars = :s, featured = :f WHERE levelID = :l");
			$q->execute([':l' => $levelID, ':f' => $featured, ':s' => $stars]);
			echo("1");
			break;

		default:
			$q = $db->prepare("UPDATE levels SET diff = '0', auto = '0', demon = '0', stars = '0', featured = '0' WHERE levelID = :l");
			$q->execute([':l' => $levelID]);
			echo("1");
			break;
	}

	if($featured != "0") {
		$q = $db->prepare("UPDATE levels SET verifiedCoins = '1' WHERE levelID = :l");
		$q->execute([':l' => $levelID]);
	}

	deleteSuggestion($levelID);
} else {
	if ($r["length"] <= 1) {
		if ($stars >= 2) {
			switch ($stars) {
				case '1':
					addSuggestion($accountID, 1, $featured, $levelID, 50, 1, 0, $featured == 1 ? 1 : 0);
					exit("1");
					break;

				default:
					addSuggestion($accountID, 2, $featured, $levelID, 10, 0, 0, $featured == 1 ? 1 : 0);
					exit("1");
					break;
			}
		}
	}

	switch ($stars) {
		case '1':
			addSuggestion($accountID, 1, $featured, $levelID, 50, 1, 0, $featured == 1 ? 1 : 0);
			echo("1");
			break;

		case '2':
			addSuggestion($accountID, 2, $featured, $levelID, 10, 0, 0, $featured == 1 ? 1 : 0);
			echo("1");
			break;

		case '3':
			addSuggestion($accountID, 3, $featured, $levelID, 20, 0, 0, $featured == 1 ? 1 : 0);
			echo("1");
			break;

		case '4':
			addSuggestion($accountID, 4, $featured, $levelID, 30, 0, 0, $featured == 1 ? 1 : 0);
			echo("1");
			break;

		case '5':
			addSuggestion($accountID, 5, $featured, $levelID, 30, 0, 0, $featured == 1 ? 1 : 0);
			echo("1");
			break;

		case '6':
			addSuggestion($accountID, 6, $featured, $levelID, 40, 0, 0, $featured == 1 ? 1 : 0);
			echo("1");
			break;

		case '7':
			addSuggestion($accountID, 7, $featured, $levelID, 40, 0, 0, $featured == 1 ? 1 : 0);
			echo("1");
			break;

		case '8':
			addSuggestion($accountID, 8, $featured, $levelID, 50, 0, 0, $featured == 1 ? 1 : 0);
			echo("1");
			break;

		case '9':
			addSuggestion($accountID, 9, $featured, $levelID, 50, 0, 0, $featured == 1 ? 1 : 0);
			echo("1");
			break;

		case '10':
			addSuggestion($accountID, 10, $featured, $levelID, 50, 0, 1, $featured == 1 ? 1 : 0);
			echo("1");
			break;

		default:
			addSuggestion($accountID, 0, 0, $levelID, 0, 0, 0, 0);
			echo("1");
			break;
	}
}

exit;
?>
