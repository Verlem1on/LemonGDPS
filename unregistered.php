<?php

function tryCreateUser($udid, $userName) {
    include "connection.php";

    $q = $db->prepare("SELECT * FROM users WHERE udid = :u");
    $q->execute([':u' => $udid]);

    if ($q->rowCount() > 0) {
        $r = $q->fetch(2);

        return $r['userID'];
    } else {
        $q = $db->prepare("INSERT INTO users (userName, udid) VALUES (:un, :ud)");
        $q->execute([':un' => $userName, ':ud' => $udid]);

        return $db->lastInsertId();
    }
}

function isUserExists($udid) {
    include "connection.php";

    $q = $db->prepare("SELECT * FROM users WHERE udid = :u");
    $q->execute([':u' => $udid]);

    if ($q->rowCount() > 0) {
        return true;
    } else return false;
}