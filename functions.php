<?php
	//lisada kaustad
	require("../../config.php");
	$database = "if17_mihkel_2";
	$photo_dir = "uploads/";
	$thumb_dir = "thumbnails/";
	
	//muuta hiljem muutujad vastavaks
	function displayImages(){
		$html = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, filename, thumbnail, clicks, likes FROM pildid ORDER BY clicks DESC");
		$stmt->bind_result($id, $filename, $thumbnail, $clickCount, $likeCount);
		$stmt->execute();
		//kõik pisipildid
		while ($stmt->fetch()){
			$html .= '<div><a href="fullimage.php?id=' .$id .'"><img src="thumbnails/'. $thumbnail .'"></a><p>'. $clickCount. ' click(s)</p><p>'. $likeCount.' <a href="index.php?id='. $id.'">like</a>(s)</p></div>';
		}
		
		$stmt->close();
		$mysqli->close();
		echo $html;
	}
	
	function onImageClick($id){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE pildid SET clicks=clicks+1 WHERE id=?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->close();
		$mysqli->close();
	}
	
	function addLike($pic_id) {
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$checkIfLiked = $mysqli->prepare("SELECT * FROM likes WHERE ip_aadress = ? AND pic_id = ?");
		$checkIfLiked->bind_param("si", $_SERVER['REMOTE_ADDR'], $pic_id);
		$checkIfLiked->execute();
		if ($checkIfLiked->fetch()) {
			//selle IP-ga on seda pilti juba likeitud
		} else {
			$updatePildid = $mysqli->prepare("UPDATE pildid SET likes=likes+1 WHERE id=?");
			$updatePildid->bind_param("i", $pic_id);
			$updatePildid->execute();
			$updatePildid->close();
			$insertLike = $mysqli->prepare("INSERT INTO likes (pic_id, ip_aadress) VALUES (?, ?)");
			$insertLike->bind_param("is", $pic_id, $_SERVER['REMOTE_ADDR']);
			$insertLike->execute();
			$insertLike->close();
		}
		$checkIfLiked->close();
		
		$mysqli->close();
	}
	
	
?>