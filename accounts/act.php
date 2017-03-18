<?
session_start();

include '../connection.php';
require_once '../settings/settings.php';

if ($_POST["secret"] != $_SESSION["secret"]) exit("Wrong secret code.");

$key = $_POST["key"];
$act = $_POST["act"];

$key = explode(';', base64_decode($key));

if ($act == sha1(S_SALT . $key[0] . S_MISCSALT . $key[1] . ACT_SALT . $key[2])) {
  $q = $db->prepare("UPDATE accounts SET actSent = 1 WHERE userName = :u AND password = :p");
  $q->execute(array('u' => $key[0], 'p' => hash(PS_CRYPT, $key[1] . S_SALT)));
  exit("Account was successfully activated.");
} else exit("Wrong activation code.");
?>
