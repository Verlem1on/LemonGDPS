<?php
include "../connection.php";
$userName = str_replace(array("'", "(", ")", "~"), "", htmlspecialchars($_POST["userName"]));
$password = sha1(str_replace(array("'", "(", ")", "~"), "", htmlspecialchars($_POST["password"])) . "ThUj31rsRRf");
$udid = str_replace(array("'", "(", ")", "~"), "", htmlspecialchars($_POST["udid"]));

if(trim($userName) == "" || trim($password) == "") exit("-1");

# Checking for account
$q = $db->prepare("SELECT * FROM accounts WHERE userName = '$userName' AND password = '$password'");
$q->execute();

if ($q->rowCount() > 0) {
	# Checking if we have user
	$accData = $q->fetch(PDO::FETCH_ASSOC);
	$accountID = $accData["accountID"];
	$q1 = $db->prepare("SELECT * FROM users WHERE accountID = '$accountID'");
	$q1->execute();
	if ($q1->rowCount() > 0) {
		$userData = $q1->fetch(PDO::FETCH_ASSOC);
		exit("$accountID," . $userData["userID"]);
	} else {
		$q2 = $db->prepare("INSERT INTO users (userName, accountID, registered, udid) VALUES ('$userName', '$accountID', '1', '$udid')");
		$q2->execute();
		exit("$accountID," . $db->lastInsertID());
	}
} else {
	exit("-1");
}
?>