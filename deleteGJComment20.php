<?
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$commentID = sqlTrim($_POST["commentID"]);

if(disabled($accountID)) exit("-1");

if(checkGJP($gjp, $accountID)) {
	$q = $db->prepare("DELETE FROM comments WHERE commentID = :c AND accountID = :a");
	$q->execute(array('c' => $commentID, 'a' => $accountID));
	exit("1");
} else {
	exit("-1");
}
?>