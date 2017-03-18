<?
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$levelDesc = sqlTrim($_POST["levelDesc"]);
$levelID = sqlTrim($_POST["levelID"]);

if (!checkAct($accountID)) exit("-1");
tryKillAccs();

if(checkGJP($gjp, $accountID)) {
	$q = $db->prepare("SELECT * FROM users WHERE accountID = :a");
	$q->execute([':a' => $accountID]);
	$r = $q->fetch(PDO::FETCH_ASSOC);
	$q = $db->prepare("UPDATE levels SET `desc` = :d WHERE levelID = :l AND userID =:u");
	$q->execute(array('d' => htmlspecialchars($levelDesc, ENT_QUOTES), 'l' => $levelID, 'u' => $r['userID']));
	exit("1");
} else exit("-1");
?>
