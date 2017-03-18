<?php
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);

if(disabled($accountID)) exit("-1");
if (!checkAct($accountID)) exit("-1");

if (checkGJP($gjp, $accountID)) {
	$q = $db->prepare("SELECT * FROM accounts WHERE accountID = :a");
	$q->execute([':a' => $accountID]);
	$r = $q->fetch(PDO::FETCH_ASSOC);
	if(!checkAdmin($accountID)) {
		if ($r['mod'] != '1') {
			exit('-1');
		}
	}
	exit("1");
} else {
	exit("-1");
}
?>
