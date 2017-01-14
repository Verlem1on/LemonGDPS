<?php
error_reporting(0);
include "connection.php";
ini_set('memory_limit', '-1');


$usersString = "";
$songsString  = "";
$type = htmlspecialchars($_POST["type"],ENT_QUOTES);
$str = htmlspecialchars($_POST["str"]);
$accountID = htmlspecialchars($_POST["accountID"]);
$page = htmlspecialchars($_POST["page"]);
$totLevel = 0;
$querytxt = "";
$diff = htmlspecialchars($_POST["diff"]);
$star = htmlspecialchars($_POST["star"]);
$noStar = htmlspecialchars($_POST["noStar"]);
$featured = htmlspecialchars($_POST["featured"]);
$len = htmlspecialchars($_POST["len"]);
$twoPlayer = htmlspecialchars($_POST["twoPlayer"]);
$conditions = "";
$followed = htmlspecialchars($_POST["followed"]);
$song = htmlspecialchars($_POST["song"]);


if($diff != "-"){
	$txt = "";
	if($diff == -1 or $diff == -2 or $diff == -3){
		switch($diff){
			case -1:
				$txt = $txt." diff = '0' ";
				break;
				
			case -2;
				$txt = $txt." demon = 1";
				break;
			
			case -3;
				$txt = $txt." auto = 1";
				break;
		}
	}else{
		$temp = split(",", $diff);
		
		for($k = 0; $k < count($temp); $k++){
			if($k != 0){
				$txt = $txt." or ";
			}
			
			$txt = $txt."diff = '".($temp[$k]*10)."'";
		}
		
	}
	$conditions = $conditions." ".$txt;
}


if($song != ""){
	if(htmlspecialchars($_POST["customSong"]) == 1){
		if($conditions != "")
			$conditions = $conditions." and songID = '".($song)."'";
		else{
			$conditions = " songID = '".($song)."'";
		}
	}else{
		if($conditions != "")
			$conditions = $conditions." and song = '".($song-1)."' and songID = 0";
		else{
			$conditions = " song = '".($song-1)."' and songID = 0";
		}
	}
	
}



if($star != ""){
	if($conditions != "")
		$conditions = $conditions." and stars != '0'";
	else{
		$conditions = " stars != '0'";
	}
}

if($noStar != ""){
	if($conditions != "")
		$conditions = $conditions." and stars < '1'";
	else{
		$conditions = " stars < '1'";
	}
}

if($featured != "0"){
	if($conditions != "")
		$conditions = $conditions." and featured != '0'";
	else{
		$conditions = " featured != '0'";
	}
}

if($twoPlayer != "0"){
	if($conditions != "")
		$conditions = $conditions." and twoPlayer != '0'";
	else{
		$conditions = " twoPlayer != '0'";
	}
}

if($len != "-"){
	$txt = "";
	$temp = split(",", $len);
		
	for($k = 0; $k < count($temp); $k++){
		if($k != 0){
			$txt = $txt." or ";
		}
		
		$txt = $txt."length = '".($temp[$k])."'";
	}
	if($conditions != "")
		$conditions = $conditions." and ".$txt."";
	else{
		$conditions = "".$txt; 	
	}
}

switch ($type){
	case 0:
	
		if(is_numeric($str)){
			if($conditions != ""){
				$querytxt = "SELECT * FROM levels  WHERE  levelID = '".$str."' ORDER BY likes DESC";
			}else{
				$querytxt = "SELECT * FROM levels  WHERE  levelID = '".$str."' ORDER BY likes DESC";
			}
		}else{
			if($conditions != ""){
				$querytxt = "SELECT * FROM levels WHERE name LIKE '".$str."%' and (".$conditions.") ORDER BY likes DESC";
			}else{
				$querytxt = "SELECT * FROM levels WHERE name LIKE '".$str."%' ORDER BY likes DESC";
			}
		}
		break;
	
	case 1:
		if($conditions != ""){
			$querytxt = "SELECT * FROM levels WHERE ".$conditions." ORDER BY downloads DESC";
		}else{
			$querytxt = "SELECT * FROM levels  ORDER BY downloads DESC";
		}
		break;
	
	case 2:
		if($conditions != ""){
			$querytxt = "SELECT * FROM levels WHERE ".$conditions." ORDER BY likes DESC";
		}else{
			$querytxt = "SELECT * FROM levels  ORDER BY likes DESC";
		}
		break;
		
	case 4:
		if($conditions != ""){
			$querytxt = "SELECT * FROM levels WHERE ".$conditions." ORDER BY levelID DESC";
		}else{
			$querytxt = "SELECT * FROM levels  ORDER BY levelID DESC";
		}
		break;
	
	case 5:
		$querytxt = "SELECT * FROM levels WHERE userID = '$str' ORDER BY levelID DESC";
		break;
	
	case 6:
		$querytxt = "SELECT * FROM `levels` WHERE featured ORDER BY levelID DESC";
		break;
	
	case 7:
		$querytxt = "SELECT * FROM levels WHERE objects > '4999' ORDER BY levelID DESC";
		break;
	
	case 11:
		$querytxt = "SELECT * FROM levels WHERE stars != '0' ORDER BY levelID DESC";
		break;
}

$lvls = "";

if($type == 13){
	$usersString = "";
	if($conditions != ""){
		$query2 = $db->prepare("SELECT * FROM levels WHERE ".$conditions." ORDER BY levelID DESC");
	}else{
		$query2 = $db->prepare("SELECT * FROM levels ORDER BY levelID DESC");
	}
	$query2->execute();
	$levels = $query2->fetchAll();
	$query2 = $db->prepare("SELECT * FROM friends WHERE accountID ='".$accountID."'  ");
	$query2->execute();
	$friends = $query2->fetchAll();
	$k = 0;
	foreach($levels as $level1){
		foreach($friends as $friend){
			
			if($k == ($page*10)+10) break;

			if($friend["targetID"] == $level1["accountID"]){
				
				if($k >= $page*10){
					if($k > $page*10) { echo "|"; $lvls .= ","; }
					$lvls .= $level1["levelID"];
					echo "1:".$level1["levelID"].":2:".$level1["name"].":5:".$level1["version"].":6:".$level1["userID"].":8:10:9:".$level1["diff"].":10:".$level1["downloads"].":12:".$level1["song"].":13:".$level1["game"].":14:".$level1["likes"].":17:".$level1["demon"].":25:".$level1["auto"].":18:".$level1["stars"].":19:".$level1["featured"].":3:".$level1["desc"].":15:".$level1["length"].":30:".$level1["original"].":31:0:37:".$level1["coins"].":38:".$level1["verifiedCoins"].":39:".$level1["requestedStars"].":35:".$level1["songID"]; 
				
					
					if($k == $page*10){
						$usersString = $usersString.$level1["userID"].":".$level1["userName"].":".$level1["accountID"];
					}else{
						
						$usersString = $usersString."|".$level1["userID"].":".$level1["userName"].":".$level1["accountID"];
					}
				
				}
				$k++;
			}
			
		}
	}
	
	$k = 0;	
	foreach($levels as $level1){
		foreach($friends as $friend){
			if($friend["targetID"] == $level1["accountID"]){
				$k++;
			}
			
		}
	}
	
	echo "###".$k.":".($page*10).":10";
}


if($type == 12){
	$usersString = "";
	if($conditions != ""){
		$query2 = $db->prepare("SELECT * FROM levels WHERE ".$conditions." ORDER BY levelID DESC");
	}else{
		$query2 = $db->prepare("SELECT * FROM levels ORDER BY levelID DESC");
	}
	
	$query2->execute();
	$levels = $query2->fetchAll();
	$friends = split(",", $followed);
	$k = 0;
	foreach($levels as $level1){
		foreach($friends as $friend){
			
			if($k == ($page*10)+10) break;
			
			
			
			if($friend == $level1["accountID"]){
				
				if($k>= $page*10){
					if($k > ($page*10)) { echo "|"; $lvls .= ","; }
					$lvls .= $level1["levelID"];
					echo "1:".$level1["levelID"].":2:".$level1["name"].":5:".$level1["version"].":6:".$level1["userID"].":8:10:9:".$level1["diff"].":10:".$level1["downloads"].":12:".$level1["song"].":13:".$level1["game"].":14:".$level1["likes"].":17:".$level1["demon"].":25:".$level1["auto"].":18:".$level1["stars"].":19:".$level1["featured"].":3:".$level1["desc"].":15:".$level1["length"].":30:".$level1["original"].":31:0:37:".$level1["coins"].":38:".$level1["verifiedCoins"].":39:".$level1["requestedStars"].":35:".$level1["songID"]; 

				}
				
				$k++;
			}
			
		}
	}
	
	$k = 0;	
	foreach($levels as $level1){
		foreach($friends as $friend){
			if($friend == $level1["accountID"]){
				$k++;
			}
			
		}
	}
	
	echo "###".$k.":".($page*10).":10";
}

if($type == 10){
	$arr = explode( ',', htmlspecialchars($_POST["str"],ENT_QUOTES) );
    
    for($k = 0; $k < count($arr) ; $k ++){
    	$query=$db->prepare("select * from levels where levelID = ".htmlspecialchars($arr[$k],ENT_QUOTES));
        $query->execute();
        $result2 = $query->fetchAll();
        $result = $result2[0];
    	
    	if($k > 0) { echo "|"; $lvls .= ","; }
    	$lvls .= $result["levelID"];
        echo "1:".$result["levelID"].":2:".$result["name"].":5:".$result["version"].":6:".$result["userID"].":8:10:9:".$result["diff"].":10:".$result["downloads"].":12:".$result["song"].":13:".$result["game"].":14:".$result["likes"].":17:".$result["demon"].":25:".$result["auto"].":18:".$result["stars"].":19:".$result["featured"].":3:".$result["desc"].":15:".$result["length"].":30:".$result["original"].":31:0:37:".$result["coins"].":38:".$result["verifiedCoins"].":39:".$result["requestedStars"].":35:".$result["songID"];
    }
    echo "#992::##1:0:1";
}

if($type <15 ){
	$query2 = $db->prepare($querytxt);
	$query2->execute();
	
	if ($query2->rowCount() > 0) {
		$result = $query2->fetchAll();
		for($k = 0; $k < 10 ; $k ++){
			$currentLevel = ($page*10)+$k;
			
			$level1 = $result[$currentLevel];
			
			if($currentLevel >= count($result)) break;
			
			if($k != 0) { echo "|"; $lvls .= ","; }
			$lvls .= $level1["levelID"];
			echo "1:".$level1["levelID"].":2:".$level1["name"].":5:".$level1["version"].":6:".$level1["userID"].":8:10:9:".$level1["diff"].":10:".$level1["downloads"].":12:".$level1["song"].":13:".$level1["game"].":14:".$level1["likes"].":17:".$level1["demon"].":25:".$level1["auto"].":18:".$level1["stars"].":19:".$level1["featured"].":3:".$level1["desc"].":15:".$level1["length"].":30:".$level1["original"].":31:0:37:".$level1["coins"].":38:".$level1["verifiedCoins"].":39:".$level1["requestedStars"].":35:".$level1["songID"]; 
		
			$id = $level1["userID"];
			$query = $db->prepare("SELECT * FROM users WHERE userID = '$id'");
			$query->execute();
			$res = $query->fetchAll();
			$user = $res[0];
			
			if($k == 0){
				$usersString = $usersString.$level1["userID"].":".$user["userName"].":".$user["accountID"];
			}else{
				$usersString = $usersString."|".$level1["userID"].":".$user["userName"].":".$user["accountID"];
			}
			$y = 0;
			/*
			if($level1["songID"] != 0){
				$id = $level1["userID"];
				$query = $db->prepare("SELECT * FROM songs WHERE levelID = '".$level1["levelID"]."'");
				$query->execute();
				$res = $query->fetchAll();
				$song = $res[0];
				if($y == 0){
					$songsString = $songsString.$song["songString"];
				}else{
					$songsString = $songsString.":".$song["songString"];
				}
			}*/
		}		

		$totLevel = count($result);
		echo "#";
		echo $usersString;
		echo "#";
		echo "#";
		echo $totLevel.":".($page*10).":10";
	}
}

echo "#"
?>