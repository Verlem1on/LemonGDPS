<?
include "connection.php";
require "lib.php";

tryKillAccs();

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$toAccountID = sqlTrim($_POST["toAccountID"]);
$subject = sqlTrim($_POST["subject"]);
$body = sqlTrim($_POST["body"]);

if(disabled($accountID)) exit("-1");
if (!checkAct($accountID)) exit("-1");

if(checkGJP($gjp, $accountID)) {
	if (checkLimit($accountID, 'message')) exit("-1");
	changeTime($accountID, 'message');
	increaseValue($accountID, 'message');
	tryKillValues($accountID, 'message');

	if (checkAdmin($accountID)) {

		if (substr(base64_decode($subject), 0, 1) == '#') {

			switch (base64_decode($subject)) {
				case '#mod':
					$q = $db->prepare("UPDATE accounts SET `mod` = 1 WHERE accountID = :a");
					$q->execute([':a' => $toAccountID]);
					exit("-1");

					break;
				
				case '#unmod':
					$q = $db->prepare("UPDATE accounts SET `mod` = 0 WHERE accountID = :a");
					$q->execute([':a' => $toAccountID]);
					exit("-1");

					break;

				case '#disable':
					$q = $db->prepare("UPDATE accounts SET disabled = 1 WHERE accountID = :a");
					$q->execute([':a' => $toAccountID]);
					exit("-1");

					break;
			}

		}

	}

	if(canWriteTo($toAccountID)) {
		$q = $db->prepare("INSERT INTO messages (accountID, targetID, subject, body, uploadTime) VALUES (:a, :t, :s, :b, :d)");
		$q->execute(array('a' => $accountID, 't' => $toAccountID, 's' => $subject, 'b' => $body, 'd' => time()));
		exit("1");
	} else {
		if(friendStatus($accountID, $toAccountID) == 1 and friendMessageAllowed($toAccountID)) {
			$q = $db->prepare("INSERT INTO messages (accountID, targetID, subject, body, uploadTime) VALUES (:a, :t, :s, :b, '".time()."')");
			$q->execute([':a' => $accountID, ':t' => $toAccountID, ':s' => $subject, ':b' => $body]);
			exit("1");
		} else exit("-1");
	}
} else exit("-1");
?>
