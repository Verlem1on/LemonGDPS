<?php
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);

if(disabled($accountID)) exit("-1");

if (checkGJP($gjp, $accountID)) {
	$q = $db->prepare("SELECT * FROM accounts WHERE accountID = '$accountID'");
	$q->execute();
	$r = $q->fetch(PDO::FETCH_ASSOC);
	exit($r["mod"] == "1" ? "1" : "-1");
} else {
	exit("-1");
}
?>