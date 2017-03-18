<?
require_once('gdps.php');

$accountID = $_POST['accountID'];
$udid = $_POST['udid'];
$chk = $_POST['chk'];

$quests = ProcessQuests($udid, $chk, $accountID);

$string = base64_encode( cipher( $quests, 19847 ) );
exit ( 'CyKaB' . $string . '|' . sha1( $string . 'oC36fpYaPtdg' ) );

?>