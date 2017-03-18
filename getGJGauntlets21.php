<?
include "connection.php";

$q = $db->prepare("SELECT * FROM gauntlets");
$q->execute();
$r = $q->fetchAll();

$str = "";

for ($i = 0; $i < count($r); $i++) {
  $g = $r[$i];
  $str .= $g["ID"] . $g["levels"];
  echo "1:" . $g["ID"] . ":3:" . $g["levels"];
  if($r[$i+1]["ID"] != "") echo "|";
}

exit("#" . sha1($str . "xI25fpAapCQg"));
?>
