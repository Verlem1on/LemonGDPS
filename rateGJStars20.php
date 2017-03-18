<?
include 'connection.php';

$levelID = $_POST['levelID'];
$stars = $_POST['stars'];

$q = $db->prepare("SELECT * FROM levelRatings WHERE levelID = :l");
$q->execute(array('l' => $levelID));

if ($q->rowCount() <= 0) {
  $q = $db->prepare("INSERT INTO levelRatings (levelID, nStars, nCount) VALUES (:l, :s, 1)");
  $q->execute(array('l' => $levelID, 's' => $stars));
  exit('1');
} else {
  $r = $q->fetch(PDO::FETCH_ASSOC);

  if ($r['nCount'] >= 5) {
    switch ($r['nStars'] % $r['nCount']) {
      case '1':
        $q = $db->prepare("UPDATE levels SET diff = 10 WHERE levelID = ? AND stars = 0");
        $q->execute(array($levelID));
        $q = $db->prepare("UPDATE levelRatings SET nStars = 0, nCount = 0 WHERE levelID = ? AND stars = 0");
        $q->execute(array($levelID));
        break;

      case '2':
        $q = $db->prepare("UPDATE levels SET diff = 10 WHERE levelID = ?");
        $q->execute(array($levelID));
        $q = $db->prepare("UPDATE levelRatings SET nStars = 0, nCount = 0 WHERE levelID = ? AND stars = 0");
        $q->execute(array($levelID));
        break;

      case '3':
        $q = $db->prepare("UPDATE levels SET diff = 20 WHERE levelID = ?");
        $q->execute(array($levelID));
        $q = $db->prepare("UPDATE levelRatings SET nStars = 0, nCount = 0 WHERE levelID = ? AND stars = 0");
        $q->execute(array($levelID));
        break;

      case '4':
        $q = $db->prepare("UPDATE levels SET diff = 30 WHERE levelID = ?");
        $q->execute(array($levelID));
        $q = $db->prepare("UPDATE levelRatings SET nStars = 0, nCount = 0 WHERE levelID = ? AND stars = 0");
        $q->execute(array($levelID));
        break;

      case '5':
        $q = $db->prepare("UPDATE levels SET diff = 30 WHERE levelID = ?");
        $q->execute(array($levelID));
        $q = $db->prepare("UPDATE levelRatings SET nStars = 0, nCount = 0 WHERE levelID = ? AND stars = 0");
        $q->execute(array($levelID));
      break;

      case '6':
        $q = $db->prepare("UPDATE levels SET diff = 40 WHERE levelID = ?");
        $q->execute(array($levelID));
        $q = $db->prepare("UPDATE levelRatings SET nStars = 0, nCount = 0 WHERE levelID = ? AND stars = 0");
        $q->execute(array($levelID));
        break;

      case '7':
        $q = $db->prepare("UPDATE levels SET diff = 40 WHERE levelID = ?");
        $q->execute(array($levelID));
        $q = $db->prepare("UPDATE levelRatings SET nStars = 0, nCount = 0 WHERE levelID = ? AND stars = 0");
        $q->execute(array($levelID));
        break;

      case '8':
        $q = $db->prepare("UPDATE levels SET diff = 50 WHERE levelID = ?");
        $q->execute(array($levelID));
        $q = $db->prepare("UPDATE levelRatings SET nStars = 0, nCount = 0 WHERE levelID = ? AND stars = 0");
        $q->execute(array($levelID));
        break;

      case '9':
        $q = $db->prepare("UPDATE levels SET diff = 50 WHERE levelID = ?");
        $q->execute(array($levelID));
        $q = $db->prepare("UPDATE levelRatings SET nStars = 0, nCount = 0 WHERE levelID = ? AND stars = 0");
        $q->execute(array($levelID));
        break;

      case '10':
        $q = $db->prepare("UPDATE levels SET diff = 50 WHERE levelID = ?");
        $q->execute(array($levelID));
        $q = $db->prepare("UPDATE levelRatings SET nStars = 0, nCount = 0 WHERE levelID = ? AND stars = 0");
        $q->execute(array($levelID));
        break;

      default:
        $q = $db->prepare("UPDATE levels SET diff = 10 WHERE levelID = ?");
        $q->execute(array($levelID));
        $q = $db->prepare("UPDATE levelRatings SET nStars = 0, nCount = 0 WHERE levelID = ? AND stars = 0");
        $q->execute(array($levelID));
        break;
    }
  } else {
    $q = $db->prepare("UPDATE levelRatings SET nStars = :ns, nCount = :nc WHERE levelID = :l");
    $q->execute(array('ns' => $r['nStars'] + $stars, 'nc' => $r['nCount'] + 1, 'l' => $levelID));
    exit('1');
  }
}

exit('1');
?>
