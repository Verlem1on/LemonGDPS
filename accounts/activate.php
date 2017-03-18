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
    <title>Activation</title>
  </head>

  <body>
    <form action="act.php" method="post">
      <p>Key: <input type="text" name="key"></p>
      <p>Activation code: <input type="text" name="act"></p>
      <p>Capcha: <input type="text" name="secret"></p>
      <input type="submit" name="goxd">
    </form>
    <img src="image.php?sid=<?=session_id(); ?>">
  </body>
</html>
