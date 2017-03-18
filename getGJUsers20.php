<?
include "connection.php";
require "lib.php";

updateCP();

$str = $_POST["str"];
$page = $_POST["page"];

$q = $db->prepare("SELECT * FROM users WHERE userName LIKE CONCAT(:s, '%') ORDER BY stars DESC");
$q->execute(array('s' => $str));
$r = $q->fetchAll();

if (count($r) <= 0) exit();

for ($i = 0; $i < 10; $i++) {
	$user = $r[$page*10+$i];
	if ($user["userID"] == "") break;

	echo "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":6:".$xi.":9:".$user["shareIcon"].":10:".$user["pColor"].":11:".$user["sColor"].":14:".$user["iconType"].":15:".$user["special"].":16:".$user["accountID"].":3:".$user["stars"].":8:".$user["cp"].":4:".$user["demons"];

	if ($r[$page*10+$i+1]["userID"] != "") echo "|";
}

exit("#" . count($r) . ":$page:10");
?>
