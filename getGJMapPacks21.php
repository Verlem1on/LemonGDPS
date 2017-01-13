<?
require "lib.php";
include "connection.php";

$page = sqlTrim($_POST["page"]);

$q = $db->prepare("SELECT * FROM mappacks");
$q->execute();
$r = $q->fetchAll();
$mpIDs = "";

for($i = 0; $i < 10; $i++) {
	$mp = $r[$page * 10 + $i];
	if($mp["ID"] != "") {
		$mpIDs .= $mp["ID"];
		echo "1:".$mp["ID"].":2:".$mp["name"].":3:".$mp["levels"].":4:".$mp["stars"].":5:".$mp["coins"].":6:".$mp["diff"].":7:".$mp["rgb"].":8:".$mp["rgb"];
		if($r[$page * 10 + $i + 1]["ID"] != "") {
			echo "|";
			$mpIDs .= ",";
		} else break;
	}
}

exit("#".count($r).":$page:10#".genPack($mpIDs));

function genPack($lvlsmultistring) {
	$lvlsarray = explode(",", $lvlsmultistring);
	include "connection.php";
	$hash = "";
	foreach($lvlsarray as $id){
		$query=$db->prepare("select * from mappacks where ID = :i");
		$query->execute(array('i' => $id));
		$result2 = $query->fetchAll();
		$result = $result2[0];
		$hash = $hash . $result["ID"][0].$result["ID"][strlen($result["ID"])-1].$result["stars"].$result["coins"];
	}
	return sha1($hash . "xI25fpAapCQg");
}
?>