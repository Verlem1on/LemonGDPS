<?
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$levelID = sqlTrim($_POST["levelID"]);

if(disabled($accountID)) exit("-1");

if(checkGJP($gjp, $accountID)) {
	$q = $db->prepare("DELETE FROM levels WHERE levelID = :l");
	$q->execute(array('l' => $levelID));
	exit("1");
} else {
	exit("-1");
}
?>