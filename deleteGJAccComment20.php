<?
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$commentID = sqlTrim($_POST["commentID"]);

if(checkGJP($gjp, $accountID)) {
	$q = $db->prepare("DELETE FROM comments WHERE commentID = '$commentID' AND accountID = '$accountID'");
	$q->execute();
	exit("1");
} else {
	exit("-1");
}
?>