<?
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$levelID = sqlTrim($_POST["levelID"]);

if(checkGJP($gjp, $accountID)) {
	$q = $db->prepare("DELETE FROM levels WHERE levelID = '$levelID'");
	$q->execute();
	exit("1");
} else {
	exit("-1");
}
?>