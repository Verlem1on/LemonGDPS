<?
include "connection.php";
require_once "lib.php";
require_once 'gdps.php';

$accountID = htmlspecialchars($_POST["accountID"], ENT_QUOTES);
$udid = htmlspecialchars($_POST["udid"], ENT_QUOTES);
$chk = htmlspecialchars($_POST["chk"], ENT_QUOTES);
$gjp = htmlspecialchars($_POST["gjp"], ENT_QUOTES);
$rewardType = htmlspecialchars($_POST["rewardType"], ENT_QUOTES);

if(!checkGJP($gjp, $accountID)) exit("-1");
if (!checkAct($accountID)) exit("-1");

$string = base64_encode( cipher( ProcessRewards($accountID, $udid, $chk, $rewardType), 59182 ) );

exit ('CyKaB' . $string . '|' . sha1( $string . 'pC26fpYaQCtg' ));
?>
