<?php
include "connection.php";
require "lib.php";

//38,39,40 are notification counters
//18 = enabled (0) or disabled (1) messaging
//19 = enabled (0) disabled (1) friend requests
//31 = isnt (0) or is (1) friend or (3) incoming request or (4) outgoing request

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$targetAccountID = sqlTrim($_POST["targetAccountID"]);

if(disabled($accountID)) exit("-1");

if (checkGJP($gjp, $accountID)) {
	$q = $db->prepare("SELECT * FROM users WHERE accountID = '$targetAccountID'");
	$q->execute();
	$user = $q->fetch(PDO::FETCH_ASSOC);
	# Getting account data
	$q1 = $db->prepare("SELECT * FROM accounts WHERE accountID = '$targetAccountID'");
	$q1->execute();
	$usr = $q1->fetch(PDO::FETCH_ASSOC);

	$btop = $usr["banned"] == 0 ? false : true;
	$top = calcTop($targetAccountID);
	
	if($btop) {
		$top = 0;
	}

	# Checking is friend
	$friendStatus = friendStatus($accountID, $targetAccountID);
	# Checking messaging
	$messageStatus = messageStatus($targetAccountID);
	if($friendStatus == "1" and $messageStatus == "1") $messageStatus = "0";
	else if($messageStatus == "2") $messageStatus = "1";
	# Checking blocking
	$q = $db->prepare("SELECT * FROM blocked WHERE accountID = :t AND targetID = :a");
	$q->execute(array('a' => $accountID, 't' => $targetAccountID));
	if($q->rowCount() > 0) exit("1:".$user["userName"].":2:".$user["userID"].":13:0:17:0:10:0:11:0:3:0:46:0:4:0:8:0:18:1:19:1:20::21:0:22:0:23:0:24:0:25:0:26:0:28:0:43:1:47:1:30:0:16:".$user["accountID"].":31:0:44::45::38::39::40::29:1");

	if($accountID == $targetAccountID) {
		exit("1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":10:".$user["pColor"].":11:".$user["sColor"].":3:".$user["stars"].":46:0:4:".$user["demons"].":8:".$user["cp"].":18:$messageStatus:19:".$usr["frAllowed"].":20:".$usr["ytLink"].":21:".$user["icon"].":22:".$user["ship"].":23:".$user["ball"].":24:".$user["ufo"].":25:".$user["wave"].":26:".$user["robot"].":28:".$user["glow"].":43:1:47:1:30:$top:16:".$user["accountID"].":31:0:44::45::38:".newMessages($targetAccountID).":39:".newRequests($targetAccountID).":40:".newFriends($targetAccountID).":29:1");
	} else {
		exit("1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":10:".$user["pColor"].":11:".$user["sColor"].":3:".$user["stars"].":46:0:4:".$user["demons"].":8:".$user["cp"].":18:$messageStatus:19:".$usr["frAllowed"].":20:".$usr["ytLink"].":21:".$user["icon"].":22:".$user["ship"].":23:".$user["ball"].":24:".$user["ufo"].":25:".$user["wave"].":26:".$user["robot"].":28:".$user["glow"].":43:1:47:1:30:$top:16:".$user["accountID"].":31:$friendStatus:44::45::38::39::40::29:1");
	}
} else {
	exit("-1");
}
?>