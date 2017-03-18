<?
session_start();

include "../connection.php";

if ($_POST["secret"] != $_SESSION["secret"]) exit("Wrong capcha.");

$q = $db->prepare("SELECT * FROM accounts WHERE userName = :u AND email = :e");
$q->execute(array('u' => $_POST["userName"], 'e' => $_POST["email"]));

if ($q->rowCount() <= 0) exit("Failed - no users found or you inputted wrong email.");

$headers = "From: ".ACT_EMAIL."\r\nReply-To: ".ACT_EMAIL."\r\nX-Mailer: PHP/".phpversion();

$send = mail($_POST["email"], ACT_HREPASS, ACT_REPASS_2, $headers);

if (!$send) exit("Failed to send e-mail.");

exit("Message was sent to your e-mail.");
?>
