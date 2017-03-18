<?
include "connection.php";
require "lib.php";

$accountID = $_POST["accountID"];
$gjp = $_POST["gjp"];

if(!checkGJP($gjp, $accountID)) exit("-1");
if (!checkAct($accountID)) exit("-1");

$q1 = $db->prepare("SELECT * FROM dailyLevels ORDER BY dailyID DESC");
$q1->execute();
$r1 = $q1->fetchAll();
$currentDaily = $r1[0];

$mn = strtotime("tomorrow 00:00:00");
$curr = $mn - time();

exit($currentDaily["dailyID"] . "|$curr");
?>
