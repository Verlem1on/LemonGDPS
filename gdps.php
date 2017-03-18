<?

function ProcessQuests($udid, $chk, $accountID) {

    include 'connection.php';
    include 'settings/quests.php';

    $chk = cipher( base64_decode( substr( $chk, 5 ) ), 19847 );

    $userID = GetUserIDFromAccountID( $accountID );

    $questID = GenerateRandomID();

    $questID1 = $questID;
    $questID2 = $questID + 1;
    $questID3 = $questID + 2;

    $q = $db->prepare("SELECT * FROM userStuff WHERE accountID = :a");
    $q->execute(array('a' => $accountID));

    $timeLeft = 0;

    if ($q->rowCount() > 0) {
        $r = $q->fetch(PDO::FETCH_ASSOC);

        $timeLeft = time() - $r['questTime'];

        if ($timeLeft >= 3600) $timeLeft = 0;

        $q = $db->prepare("UPDATE userStuff SET questTime = :t WHERE accountID = :a");
        $q->execute(array('a' => $accountID, 't' => time()));
    } else {
        $q = $db->prepare("INSERT INTO userStuff (accountID, questTime) VALUES (:a, :t)");
        $q->execute(array('a' => $accountID, 't' => time()));
    }

    $str = 'CyKaB:';
    $str .= $userID;
    $str .= ':';
    $str .= $chk;
    $str .= ':';
    $str .= $udid;
    $str .= ':';
    $str .= $accountID;
    $str .= ':';
    $str .= $timeLeft;
    $str .= ':';
    $str .= "$questID1," . $quest[0][1] . ',' . $quest[0][2] . ',' . $quest[0][3] . ',' . $quest[0][0];
    $str .= ':';
    $str .= "$questID2," . $quest[1][1] . ',' . $quest[1][2] . ',' . $quest[1][3] . ',' . $quest[1][0];
    $str .= ':';
    $str .= "$questID3," . $quest[2][1] . ',' . $quest[2][2] . ',' . $quest[2][3] . ',' . $quest[2][0];

    return $str;
}

function GetUserIDFromAccountID( $accountID ) {

    include 'connection.php';

    $q = $db->prepare("SELECT * FROM users WHERE accountID = :a");
    $q->execute(array('a' => $accountID));

    $r = $q->fetch(PDO::FETCH_ASSOC);

    return $r['userID'];

}

function GenerateRandomID() {

    $a = rand(0, 65535) * 50;
    $b = time();

    return floor($b / $a) + 69;

}

function ProcessRewards($accountID, $udid, $chk, $rewardType) {

    include 'connection.php';
    include 'settings/quests.php';

    $chk = cipher( base64_decode( substr( $chk, 5 ) ), 59182 );

    $userID = GetUserIDFromAccountID($accountID);

    $chestTimeLeft = 0;
    $bigTimeLeft = 0;

    $co = 0;
    $bo = 0;

    $q = $db->prepare("SELECT * FROM userStuff WHERE accountID = :a");
    $q->execute(array('a' => $accountID));

    if ($q->rowCount() > 0) {
        $r = $q->fetch(PDO::FETCH_ASSOC);

        $chestTimeLeft = time() - $r['chestTime'];
        $bigTimeLeft = time() - $r['bigChestTime'];

        if ($chestTimeLeft >= 3600) $chestTimeLeft = 0;
        else $chestTimeLeft = 3600 - (time() - $r['chestTime']);

        if ($bigTimeLeft >= 12800 * 2) $bigTimeLeft = 0;
        else $bigTimeLeft = 12800 * 2 - (time() - $r['bigChestTime']);

        $co = $r['chestCount'];
        $bo = $r['bigCount'];
    } else {
        $q = $db->prepare("INSERT INTO userStuff (accountID, chestTime, bigChestTime) VALUES (:a, :t, :t)");
        $q->execute(array('a' => $accountID, 't' => time()));
    }

    if ($rewardType == 1) {
        $q = $db->prepare("UPDATE userStuff SET chestCount = :i, chestTime = :t WHERE accountID = :a");
        $q->execute([':i' => $co + 1, ':a' => $accountID, ':t' => time()]);
        $co += 1;
    } else if ($rewardType == 2) {
        $q = $db->prepare("UPDATE userStuff SET bigCount = :i, bigChestTime = :t WHERE accountID = :a");
        $q->execute([':i' => $bo + 1, ':a' => $accountID, ':t' => time()]);
        $bo += 1;
    }

    $q = $db->prepare("SELECT * FROM rewards");
    $q->execute();
    $r = $q->fetch(2);

    $str = 'CyKaT:';
    $str .= $userID;
    $str .= ':';
    $str .= $chk;
    $str .= ':';
    $str .= $udid;
    $str .= ':';
    $str .= $accountID;
    $str .= ':';
    $str .= $chestTimeLeft;
    $str .= ':';
    $str .= rand(10, $r['chestOrbs']) . ',' . rand(0, $r['chestDiamonds']) . ',' . rand(0, $r['chestShards']) . ',' . rand(0, $r['chestSpecial']);
    $str .= ":$co:";
    $str .= $bigTimeLeft;
    $str .= ':';
    $str .= rand(100, $r['bigOrbs']) . ',' . rand(0, $r['bigDiamonds']) . ',' . rand(0, $r['bigShards']) . ',' . rand(0, $r['bigSpecial']);
    $str .= ":$bo:";
    $str .= $rewardType;

    return $str;

}

function cipher($plaintext, $key) {
    $key = text2ascii($key);
    $plaintext = text2ascii($plaintext);
    $keysize = count($key);
    $input_size = count($plaintext);
    $cipher = "";
    
    for ($i = 0; $i < $input_size; $i++)
        $cipher .= chr($plaintext[$i] ^ $key[$i % $keysize]);
    return $cipher;
}

function plaintext($cipher, $key) {
    $key = text2ascii($key);
    $cipher = text2ascii($cipher);
    $keysize = count($key);
    $input_size = count($cipher);
    $plaintext = "";
    
    for ($i = 0; $i < $input_size; $i++)
        $plaintext .= chr($cipher[$i] ^ $key[$i % $keysize]);
    return $plaintext;
}
function text2ascii($text) {
    return array_map('ord', str_split($text));
}
function ascii2text($ascii) {
    $text = "";
    foreach($ascii as $char)
        $text .= chr($char);
    return $text;
}
?>