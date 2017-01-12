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

	if($accountID == $targetAccountID) {
		exit("1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":10:".$user["pColor"].":11:".$user["sColor"].":3:".$user["stars"].":46:0:4:".$user["demons"].":8:".$user["cp"].":18:".$usr["msgAllowed"].":19:".$usr["frAllowed"].":20:".$usr["ytLink"].":21:".$user["icon"].":22:".$user["ship"].":23:".$user["ball"].":24:".$user["ufo"].":25:".$user["wave"].":26:".$user["robot"].":28:".$user["glow"].":43:1:47:1:30:$top:16:".$user["accountID"].":31:0:44::45::38:".newMessages($targetAccountID).":39:".newRequests($targetAccountID).":40:".newFriends($targetAccountID).":29:1");
	} else {
		exit("1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":10:".$user["pColor"].":11:".$user["sColor"].":3:".$user["stars"].":46:0:4:".$user["demons"].":8:".$user["cp"].":18:1:19:1:20:yt:21:".$user["icon"].":22:".$user["ship"].":23:".$user["ball"].":24:".$user["ufo"].":25:".$user["wave"].":26:".$user["robot"].":28:".$user["glow"].":43:1:47:1:30:$top:16:".$user["accountID"].":31:3:44::45::38::39::40::29:1");
	}
} else {
	exit("-1");
}
?>