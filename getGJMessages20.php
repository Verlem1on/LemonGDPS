<?
include "connection.php";
require "lib.php";

$accountID = sqlTrim($_POST["accountID"]);
$gjp = sqlTrim($_POST["gjp"]);
$page = sqlTrim($_POST["page"]);
$getSent = sqlTrim($_POST["getSent"]);

if(disabled($accountID)) exit("-1");
if (!checkAct($accountID)) exit("-1");

if(checkGJP($gjp, $accountID)) {
	if ($getSent) {

		$q = $db->prepare("SELECT * FROM messages WHERE accountID = :t ORDER BY messageID DESC");
		$q->execute([':t' => $accountID]);
		$r = $q->fetchAll();

		$uString = "";

		for ($i = 0; $i < count($r); $i++) {

			$m = $r[$i];

			$q = $db->prepare("SELECT userName, userID FROM users WHERE accountID = :a");
			$q->execute([':a' => $m['targetID']]);
			$u = $q->fetch(2);

			echo "6:" . $u['userName'] . ":3:" . $u['userID'] . ":2:" . $m['targetID'] . ":1:" . $m['messageID'] . ":4:" . $m['subject'] . ":8:" . $m['read'] . ":9:1:7:" . makeTime($m['uploadTime']);
			$uString .= $u['userID'] . ':' . $u['userName'] . ':' . $m['targetID'];

			if ($i != count($r) - 1) {
				echo '|';
				$uString .= '|';
			}
		}

		echo '#' . $uString . '#:50:0';

	} else {
        $q = $db->prepare("SELECT * FROM messages WHERE targetID = :t ORDER BY messageID DESC");
        $q->execute([':t' => $accountID]);
        $r = $q->fetchAll();

        $uString = "";

        for ($i = 0; $i < count($r); $i++) {

            $m = $r[$i];

            $q = $db->prepare("SELECT userName, userID FROM users WHERE accountID = :a");
            $q->execute([':a' => $m['accountID']]);
            $u = $q->fetch(2);

            echo "6:" . $u['userName'] . ":3:" . $u['userID'] . ":2:" . $m['accountID'] . ":1:" . $m['messageID'] . ":4:" . $m['subject'] . ":8:" . $m['read'] . ":9:0:7:" . makeTime($m['uploadTime']);
            $uString .= $u['userID'] . ':' . $u['userName'] . ':' . $m['accountID'];

            if ($i != count($r) - 1) {
                echo '|';
                $uString .= '|';
            }
        }

        echo '#' . $uString . '#:50:0';
	}
}
?>
