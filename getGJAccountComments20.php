<?php
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$page = sqlTrim($_POST["page"]);

if(disabled($accountID)) exit("-1");
if (!checkAct($accountID)) exit("-1");

$q = $db->prepare("SELECT * FROM comments WHERE accountComment = '1' AND accountID = :a ORDER BY uploadTime DESC");
$q->execute(array('a' => $accountID));

if($q->rowCount() <= 0) exit("#0:0:10");

$r = $q->fetchAll();
$page = $page * 10;

for($i = 0; $i < 10; $i++) {
	$c = $r[$page + $i];
	if($c["commentID"] != "") {
		if ($i != 0) echo "|";
	} else break;
	echo "2~".$c["comment"]."~3~".$c["userID"]."~4~".$c["likes"]."~5~0~7~0~9~".makeTime($c["uploadTime"])."~6~".$c["commentID"];
}

exit("#".count($r).":$page:10");
?>
