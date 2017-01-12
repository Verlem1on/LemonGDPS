<?
include "connection.php";
require "lib.php";
require "gjValues.php";

$levelID = sqlTrim($_POST["levelID"]);

$q = $db->prepare("SELECT * FROM levels WHERE levelID = '$levelID'");
$q->execute();

if($q->rowCount() <= 0) exit("-1");
$result = $q->fetch(PDO::FETCH_ASSOC);

echo "1:".$result["levelID"].":2:".$result["name"].":3:".$result["desc"].":4:".$result["string"].":5:".$result["version"].":6:".$result["userID"].":8:10:9:".$result["diff"].":10:".$result["downloads"].":11:1:12:".$result["song"].":13:".$result["game"].":14:".$result["likes"].":17:".$result["demon"].":25:".$result["auto"].":18:".$result["stars"].":19:".$result["featured"].":15:".$result["length"].":30:".$result["original"].":31:0:28:".makeTime($result["uploadTime"]). ":29:".makeTime($result["updateTime"]). ":35:".$result["songID"].":36:".$result["extra"].":37:".$result["coins"].":38:".$result["verifiedCoins"].":39:".$result["requestedStars"].":27:" . encodeLP($result["password"]);

echo "#";
$q1 = $db->prepare("UPDATE levels SET downloads = '" . ($result["downloads"] + 1) . "' WHERE levelID = '$levelID'");
$q1->execute();

?>