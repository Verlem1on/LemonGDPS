<?php
include "../connection.php";
$userName = str_replace(array("'", "(", ")", "~"), "", htmlspecialchars($_POST["userName"]));
$password = sha1(str_replace(array("'", "(", ")", "~"), "", htmlspecialchars($_POST["password"])) . "ThUj31rsRRf");
$udid = str_replace(array("'", "(", ")", "~"), "", htmlspecialchars($_POST["udid"]));

if(trim($userName) == "" || trim($password) == "") exit("-1");

# Checking for account
$q = $db->prepare("SELECT * FROM accounts WHERE userName = :u AND password = :p");
$q->execute(array('u' => $userName, 'p' => $password));

if ($q->rowCount() > 0) {
	# Checking if we have user
	$accData = $q->fetch(PDO::FETCH_ASSOC);
	if($accData["disabled"] != 0) exit("-12");
	$accountID = $accData["accountID"];
	$q1 = $db->prepare("SELECT * FROM users WHERE accountID = :a");
	$q1->execute(array('a' => $accountID));
	if ($q1->rowCount() > 0) {
		$userData = $q1->fetch(PDO::FETCH_ASSOC);
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