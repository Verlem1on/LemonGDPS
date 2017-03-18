<?php
include "../connection.php";

$userName = str_replace(array("'", "(", ")", "~"), "", htmlspecialchars($_POST["userName"]));
$password = hash(PS_CRYPT, str_replace(array("'", "(", ")", "~"), "", htmlspecialchars($_POST["password"])) . S_SALT);
$gv = htmlspecialchars($_POST['gameVersion']);
$bv = htmlspecialchars($_POST['binaryVersion']);

$q = $db->prepare("SELECT * FROM accounts WHERE userName = :un AND password = :pw");
$q->execute([':un' => $userName, ':pw' => $password]);
$r = $q->fetch(PDO::FETCH_ASSOC);
echo(base64_decode($r["gameSave"]) . ";$gv;$bv;get;rekt");
?>
