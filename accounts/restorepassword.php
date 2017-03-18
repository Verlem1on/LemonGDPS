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
    <title>Restore password</title>
  </head>

  <body>
    <form action="restorepass.php" method="post">
      <p>Username: <input type="text" name="userName"></p>
      <p>E-mail: <input type="text" name="email"></p>
      <p>Secret code: <input type="text" name="secret"></p>
      <input type="submit" name="goxd">
    </form>
    <img src="image.php?sid=<?=session_id(); ?>">
  </body>
</html>
