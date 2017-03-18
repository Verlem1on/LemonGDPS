<?php
include "../connection.php";
require_once '../settings/settings.php';

$userName = str_replace(array("'", "(", ")", "~"), "", htmlspecialchars($_POST["userName"]));
$password = hash(PS_CRYPT, str_replace(array("'", "(", ")", "~"), "", htmlspecialchars($_POST["password"])) . S_SALT);
$udid = str_replace(array("'", "(", ")", "~"), "", htmlspecialchars($_POST["udid"]));

if(trim($userName) == "" || trim($password) == "") exit("-1");

# Checking for account
$q = $db->prepare("SELECT * FROM accounts WHERE userName = :u AND password = :p");
$q->execute(array('u' => $userName, 'p' => $password));

if ($q->rowCount() > 0) {
	# Checking if we have user
	$accData = $q->fetch(PDO::FETCH_ASSOC);
	if($accData["disabled"] != 0) exit("-12");
	if ($accData["actSent"] != 1) exit("-1");
	
	$accountID = $accData["accountID"];
	$q1 = $db->prepare("SELECT * FROM users WHERE accountID = :a");
	$q1->execute(array('a' => $accountID));
	if ($q1->rowCount() > 0) {
		$userData = $q1->fetch(PDO::FETCH_ASSOC);
		$q = $db->prepare("UPDATE users SET udid = :u WHERE accountID = :a");
		$q->execute([':a' => $accountID, ':u' => $udid]);
		exit("$accountID," . $userData["userID"]);
	} else {
		$q2 = $db->prepare("INSERT INTO users (userName, accountID, registered, udid) VALUES (:u, :a, '1', :ud)");
		$q2->execute(array('u' => $userName, 'a' => $accountID, 'ud' => $udid));
		exit("$accountID," . $db->lastInsertID());
	}
} else {
	exit("-1");
}
?>
