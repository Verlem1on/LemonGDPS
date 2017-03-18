<?php
$songid = $_POST['songID'];

if ($songid == "2") {
	exit("1~|~2~|~2~|~Press Start~|~3~|~0~|~4~|~MDK~|~5~|~4~|~6~|~~|~10~http://teamhax.altervista.org/dbh/mdk.mp3~|~7~|~~|~8~|~0");
}

$xml = "songID=".$songid."&secret=Wmfd2893gb7";
$url = 'http://www.boomlings.com/database/getGJSongInfo.php';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
$response = curl_exec($ch);
curl_close($ch);
echo $response;
?>