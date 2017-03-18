<?
session_start();

include "../connection.php";
require_once '../settings/settings.php';

if ($_POST["secret"] != $_SESSION["secret"]) exit("Wrong capcha.");

$q = $db->prepare("SELECT * FROM accounts WHERE userName = :u AND password = :p");
$q->execute(array('u' => $_POST["userName"], 'p' => hash(PS_CRYPT, $_POST["password"] . S_SALT)));

if ($q->rowCount() > 0) {
  $q = $db->prepare("UPDATE accounts SET userName = :np WHERE userName = :u AND password = :p");
  $q->execute(array('np' => $_POST["newPass"], 'u' => $_POST["userName"], 'p' => hash(PS_CRYPT, $_POST["password"] . S_SALT)));
  $q = $db->prepare("UPDATE users SET userName = :np WHERE userName = :u");
  $q->execute(array('np' => $_POST["newPass"], 'u' => $_POST["userName"]));
  exit("Done.");
} else exit("Error: wrong username or password.");
?>
