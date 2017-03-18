<?php
include "../connection.php";
require_once '../settings/settings.php';

$userName = str_replace(array("'", "(", ")", "~"), "", htmlspecialchars($_POST["userName"]));
$password = hash(PS_CRYPT, str_replace(array("'", "(", ")", "~"), "", htmlspecialchars($_POST["password"])) . S_SALT);

$gameSave = base64_encode($_POST["saveData"]);

$q = $db->prepare("UPDATE accounts SET gameSave = :gs WHERE userName = :un AND password = :pw");
$q->execute([':gs' => $gameSave, ':un' => $userName, ':pw' => $password]);
exit('1');
?>