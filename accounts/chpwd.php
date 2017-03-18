<?
session_start();

include "../connection.php";
require_once '../settings/settings.php';

if ($_POST["secret"] != $_SESSION["secret"]) exit("Wrong capcha.");

$q = $db->prepare("UPDATE accounts SET password = :np WHERE userName = :u AND password = :p");
$q->execute(array('np' => hash(PS_CRYPT, $_POST["newPass"] . S_SALT), 'u' => $_POST["userName"], 'p' => hash(PS_CRYPT, $_POST["password"] . S_SALT)));
exit("Done.");
?>
