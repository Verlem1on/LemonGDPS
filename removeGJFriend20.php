<?
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$targetAccountID = sqlTrim($_POST["targetAccountID"]);

if(!checkGJP($gjp, $accountID)) exit("-1");
if (!checkAct($accountID)) exit("-1");

$q = $db->prepare("DELETE FROM friends WHERE accountID = :a AND targetID = :t; DELETE FROM friends WHERE accountID = :t AND targetID = :a; DELETE FROM messages WHERE accountID = :a AND targetID = :t; DELETE FROM messages WHERE accountID = :t AND targetID = :a");
$q->execute(array('t' => $targetAccountID, 'a' => $accountID));
exit("1");
?>
