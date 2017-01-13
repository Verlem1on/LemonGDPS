<?
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$messageID = sqlTrim($_POST["messageID"]);
$isSender = sqlTrim($_POST["isSender"]);
$messages = sqlTrim($_POST["messages"]);

if(disabled($accountID)) exit("-1");

if(checkGJP($gjp, $accountID)) {
	if($messageID != "") {
		$q = $db->prepare("DELETE FROM messages WHERE messageID = :m");
		$q->execute(array('m' => $messageID));
		exit("1");
	} 

	if($messages != "") {
		if($isSender != "") {
			$mArray = explode(',', $messages);
			foreach($mArray as $m) {
				$q = $db->prepare("DELETE FROM messages WHERE messageID = :m AND accountID = :a");
				$q->execute(array('m' => $m, 'a' => $accountID));
			}
			exit("1");
		} else {
			$mArray = explode(',', $messages);
			foreach($mArray as $m) {
				$q = $db->prepare("DELETE FROM messages WHERE messageID = :m");
				$q->execute(array('m' => $messageID));
			}
			exit("1");
		}
	}
} else exit("-1");
?>