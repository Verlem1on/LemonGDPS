<?php
include "../connection.php";
$userName = str_replace(array("'", "(", ")", "~"), "", htmlspecialchars($_POST["userName"]));
$password = sha1(str_replace(array("'", "(", ")", "~"), "", htmlspecialchars($_POST["password"])) . "ThUj31rsRRf");
$email = str_replace(array("'", "(", ")", "~"), "", htmlspecialchars($_POST["email"]));

if(trim($userName) == "" || trim($password) == "" || trim($email) == "") exit("-1");

# Checking if username already exists
$q = $db->prepare("SELECT * FROM accounts WHERE userName = '$userName'");
$q->execute();
# Username used
if($q->rowCount() > 0) { exit("-2"); unset($q); }
# Else registering
$q = $db->prepare("INSERT INTO accounts (userName, password, email) VALUES ('$userName', '$password', '$email')");
$q->execute();
unset($q);
exit("1");
?>