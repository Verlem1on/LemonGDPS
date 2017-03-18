<?php
include "../connection.php";
require_once '../settings/settings.php';

$userName = str_replace(array("'", "(", ")", "~"), "", htmlspecialchars($_POST["userName"]));
$password = hash(PS_CRYPT, str_replace(array("'", "(", ")", "~"), "", htmlspecialchars($_POST["password"])) . S_SALT);
$email = str_replace(array("'", "(", ")", "~"), "", htmlspecialchars($_POST["email"]));

if(trim($userName) == "" || trim($password) == "" || trim($email) == "") exit("-1");

#Making act hash

$hash = sha1(S_SALT . $userName . S_MISCSALT . $_POST["password"] . ACT_SALT . $email);
$key = base64_encode($userName . ';' . $_POST["password"] . ';' . $email);

# Checking if username already exists
$q = $db->prepare("SELECT * FROM accounts WHERE userName = :u");
$q->execute(array('u' => $userName));
$r = $q->fetchAll();
if(count($r) > 0) { exit("-2"); }
$q1 = $db->prepare("SELECT * FROM accounts WHERE email = :u");
$q1->execute(array('u' => $email));
$r1 = $q1->fetchAll();
# Email used
if(count($r1) > 0) { exit("-3"); }

# Else registering
$q2 = $db->prepare("INSERT INTO accounts (userName, password, email, actSent, actHash, accDate) VALUES (:u, :p, :e, 0, :h, :t)");
$q2->execute(array('u' => $userName, 'p' => $password, 'e' => $email, 'h' => $hash, 't' => time()));

$headers = "From: ".ACT_EMAIL."\r\nReply-To: ".ACT_EMAIL."\r\nX-Mailer: PHP/".phpversion();

$sent = mail($email, ACT_WHEADER, ACT_WELCOMEMSG, $headers);

if ($sent) exit("1"); else exit("-1");
?>
