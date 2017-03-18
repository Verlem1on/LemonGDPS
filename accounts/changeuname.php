<?
session_start();

$alpha = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
$secret = "";
for($i=0;$i<5;$i++)
  $secret.= $alpha[rand(0,strlen($alpha)-1)];

session_id(md5(microtime()*rand()));

$_SESSION['secret'] = $secret;
?>

<html>
  <head>
    <title>Change username</title>
  </head>

  <body>
    <form action="chuname.php" method="post">
      <p>Username: <input type="text" name="userName"></p>
      <p>Password: <input type="password" name="password"></p>
      <p>New username: <input type="text" name="newPass"></p>
      <p>Capcha: <input type="text" name="secret"></p>
      <input type="submit" name="goxd">
    </form>
    <img src="image.php?sid=<?=session_id(); ?>">
  </body>
</html>
