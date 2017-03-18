<?
include "../connection.php";

require_once '../settings/settings.php';

$key = $_GET["key"];
$newPass = $_GET["newPass"];

$data = explode(',', $key);

if ($data[2] != sha1("sdfsdfsdfsdf".base64_decode($data[1]).base64_decode($data[0])."asdfasdyer43")) exit("Wrong key.");

$q = $db->prepare("UPDATE accounts SET password = :p WHERE userName = :u AND email = :e");
$q->execute(array('p' => hash(PS_CRYPT, $newPass . S_SALT), 'u' => base64_decode($data[0]), 'e' => base64_decode($data[1])));

exit("Done.");
?>
