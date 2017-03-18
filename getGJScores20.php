<?
include "connection.php";
require_once "lib.php";
require_once "unregistered.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$type = sqlTrim($_POST["type"]);
$udid = $_POST['udid'];

updateCP();

if ($accountID != '') {
    if (disabled($accountID)) exit("-1");
    if (!checkAct($accountID)) exit("-1");
}

if (!checkGJP($gjp, $accountID)) {
	if (!isUserExists($udid)) {
		exit('-1');
	}
}

switch ($type) {
	case 'top':
		$q = $db->prepare("SELECT * FROM users ORDER BY stars DESC");
		$q->execute();
		$r = $q->fetchAll();

		$bannedRemover = 0;

		for($i = 0; $i < count($r); $i++) {
			$user = $r[$i];
			$t = 1 + $i - $bannedRemover;

			if (isUserGlobalBanned($user['accountID'])) {
                $bannedRemover += 1;

                continue;
			}

			echo "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":6:".$t.":9:".$user["shareIcon"].":10:".$user["pColor"].":11:".$user["sColor"].":14:".$user["iconType"].":15:".$user["special"].":16:".$user["accountID"].":3:".$user["stars"].":8:".$user["cp"].":4:".$user["demons"].":7:".$user["accountID"].":46:".$user["diamonds"];
			if($i < 100)
				echo "|";
			else
				break;
		}
		break;

	case 'friends':
		$q = $db->prepare("SELECT * FROM friends WHERE accountID = :a");
		$q->execute(array('a' => $accountID));

		if($q->rowCount() <= 0) {
			unset($q);
			$q = $db->prepare("SELECT * FROM users WHERE accountID = :a");
			$q->execute([':a' => $accountID]);
			$user = $q->fetch(PDO::FETCH_ASSOC);
			exit("1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":6:".$t.":9:".$user["shareIcon"].":10:".$user["pColor"].":11:".$user["sColor"].":14:".$user["iconType"].":15:".$user["special"].":16:".$user["accountID"].":3:".$user["stars"].":8:".$user["cp"].":4:".$user["demons"].":7:".$user["accountID"].":46:".$user["diamonds"]);
		}

		$r = $q->fetchAll();

		for($i = 0; $i < count($r); $i++) {
			$u1 = $r[$i];
			$u = $u1["targetID"];
			$qq = $db->prepare("SELECT * FROM users WHERE accountID = :u");
			$qq->execute([':u' => $u]);
			$user = $qq->fetch(PDO::FETCH_ASSOC);
			$t = 1 + $i;
			echo "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":6:".$t.":9:".$user["shareIcon"].":10:".$user["pColor"].":11:".$user["sColor"].":14:".$user["iconType"].":15:".$user["special"].":16:".$user["accountID"].":3:".$user["stars"].":8:".$user["cp"].":4:".$user["demons"].":7:".$user["accountID"].":46:".$user["diamonds"];
			if($i < count($r) - 1) echo "|";
		}
		echo "|";
		$q = $db->prepare("SELECT * FROM users WHERE accountID = :a");
		$q->execute([':a' => $accountID]);
		$user = $q->fetch(PDO::FETCH_ASSOC);
		exit("1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":6:".$t.":9:".$user["shareIcon"].":10:".$user["pColor"].":11:".$user["sColor"].":14:".$user["iconType"].":15:".$user["special"].":16:".$user["accountID"].":3:".$user["stars"].":8:".$user["cp"].":4:".$user["demons"].":7:".$user["accountID"].":46:".$user["diamonds"]);
		break;

	case 'relative':
		$q = $db->prepare("SELECT * FROM users ORDER BY stars DESC");
		$q->execute();
		$r = $q->fetchAll();

        $bannedRemover = 0;

		for($i = 0; $i < count($r); $i++) {
			$user = $r[$i];
            $t = 1 + $i - $bannedRemover;

            if (isUserGlobalBanned($user['accountID'])) {
                $bannedRemover += 1;

                continue;
            }

			echo "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":6:".$t.":9:".$user["shareIcon"].":10:".$user["pColor"].":11:".$user["sColor"].":14:".$user["iconType"].":15:".$user["special"].":16:".$user["accountID"].":3:".$user["stars"].":8:".$user["cp"].":4:".$user["demons"].":7:".$user["accountID"].":46:".$user["diamonds"];
			if($i < 50)
				echo "|";
			else
				break;
		}
		break;

	case 'creators':
		$q = $db->prepare("SELECT * FROM users ORDER BY cp DESC");
		$q->execute();
		$r = $q->fetchAll();

        $bannedRemover = 0;

		for($i = 0; $i < count($r); $i++) {
			$user = $r[$i];
            $t = 1 + $i - $bannedRemover;

            if (isUserGlobalBanned($user['accountID'])) {
                $bannedRemover += 1;

                continue;
            }

			echo "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":6:".$t.":9:".$user["shareIcon"].":10:".$user["pColor"].":11:".$user["sColor"].":14:".$user["iconType"].":15:".$user["special"].":16:".$user["accountID"].":3:".$user["stars"].":8:".$user["cp"].":4:".$user["demons"].":7:".$user["accountID"].":46:".$user["diamonds"];
			if($i < 100)
				echo "|";
			else
				break;
		}
		break;
}
?>
