<?
include "connection.php";
require "lib.php";

$itemID = sqlTrim($_POST["itemID"]);
$like = sqlTrim($_POST["like"]);
$type = sqlTrim($_POST["type"]);

switch ($type) {
	case '1':
		# Level
		$q = $db->prepare("SELECT * FROM levels WHERE levelID = '$itemID'");
		$q->execute();
		$r = $q->fetch(PDO::FETCH_ASSOC);
		if($like == "1") $r["likes"] += 1; else $r["likes"] -= 1;
		$q = $db->prepare("UPDATE levels SET likes = '".$r["likes"]."' WHERE levelID = '$itemID'");
		$q->execute();
		exit("1");
		break;
	
	case '2':
		# Comment
		$q = $db->prepare("SELECT * FROM comments WHERE commentID = '$itemID'");
		$q->execute();
		$r = $q->fetch(PDO::FETCH_ASSOC);
		if($like == "1") $r["likes"] += 1; else $r["likes"] -= 1;
		$q = $db->prepare("UPDATE comments SET likes = '".$r["likes"]."' WHERE commentID = '$itemID'");
		$q->execute();
		exit("1");
		break;

	case '3':
		# Acc Comment
		$q = $db->prepare("SELECT * FROM comments WHERE commentID = :i AND accountComment = '1'");
		$q->execute(array('i' => $itemID));
		$r = $q->fetch(PDO::FETCH_ASSOC);
		if($like == "1") $r["likes"] += 1; else $r["likes"] -= 1;
		$q = $db->prepare("UPDATE comments SET likes = '".$r["likes"]."' WHERE commentID = '$itemID'");
		$q->execute();
		exit("1");
		break;
}
?>