<?
include "connection.php";
require "lib.php";
require "gjValues.php";

$levelID = sqlTrim($_POST["levelID"]);
$daily = false;
$dailyID = 0;

if($levelID == "-1") {
    $q = $db->prepare("SELECT * FROM dailyLevels ORDER BY dailyID DESC");
    $q->execute();
    $r1 = $q->fetchAll();
    $r = $r1[0];
    $levelID = $r["levelID"];
    $daily = true;
    $dailyID = $r["dailyID"];
}

$q = $db->prepare("SELECT * FROM levels WHERE levelID = :l");
$q->execute(array('l' => $levelID));

if($q->rowCount() <= 0) exit("-1");
$result = $q->fetch(PDO::FETCH_ASSOC);
#43: demontype
#42: epic
echo "1:".$result["levelID"].":2:".$result["name"].":3:".$result["desc"].":4:".$result["string"].":5:".$result["version"].":6:".$result["userID"].":8:10:9:".$result["diff"].":10:".$result["downloads"].":11:1:12:".$result["song"].":13:".$result["game"].":14:".$result["likes"].":17:".$result["demon"].":43:".$result["demonType"].":25:".$result["auto"].":18:".$result["stars"].":19:".$result["featured"].":42:".$result["epic"].":45:0:15:".$result["length"].":30:".$result["original"].":31:0:28:".makeTime($result["uploadTime"]). ":29:".makeTime($result["updateTime"]). ":35:".$result["songID"].":36:".$result["extra"].":37:".$result["coins"].":38:".$result["verifiedCoins"].":39:".$result["requestedStars"].":46:1:47:2:27:" . encodeLP($result["password"]);

if($daily) {
    echo ":41:" . $dailyID;
}

echo "#" . getGJdLHash($result["string"]);
$sh = $result["userID"] . "," . $result["stars"] . "," . $result["demon"] . "," . $result["levelID"] . "," . $result["verifiedCoins"] . "," . $result["featured"] . "," . $result["password"] . "," .$dailyID;
echo "#" . getSH($sh) . "#";

if($daily) {
    $q = $db->prepare("SELECT * FROM users WHERE userID = :u");
    $q->execute(array('u' => $result["userID"]));
    $r = $q->fetch(PDO::FETCH_ASSOC);

    echo $r["userID"] . ":" . $r["userName"] . ":" . $r["accountID"];
} else {
    echo $sh;
}

$q1 = $db->prepare("UPDATE levels SET downloads = :d WHERE levelID = :l");
$q1->execute(array('d' => $result["downloads"] + 1, 'l' => $levelID));

function getGJdLHash($levelString){

    $t = $levelString;


    $s = "aaaaa";
    $size = strlen($t);

    $val = intval($size/40);

    $p = 0;
    for($k = 0; $k < $size ; $k= $k+$val){
        if($p > 39) break;

        $s[$p] = $t[$k]; 
        $p++;
    }
    return sha1($s."xI25fpAapCQg");
}

function getSH($string) {
	return sha1($string . "xI25fpAapCQg");
}
?>