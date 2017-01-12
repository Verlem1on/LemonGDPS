<?php
include "../connection.php";

$userName = str_replace(array("'", "(", ")", "~"), "", htmlspecialchars($_POST["userName"]));
$password = sha1(str_replace(array("'", "(", ")", "~"), "", htmlspecialchars($_POST["password"])) . "ThUj31rsRRf");
$gameSave = base64_encode($_POST["saveData"]);

$q = $db->prepare("UPDATE accounts SET gameSave = '$gameSave' WHERE userName = '$userName' AND password = '$password'");
$q->execute();
exit('1');
?>