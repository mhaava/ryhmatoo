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
		$stmt = $mysqli->prepare("SELECT id, filename, thumbnail, clicks FROM pildid");
		$stmt->bind_result($id, $filename, $thumbnail, $clickCount);
		$stmt->execute();
		//kõik pisipildid
		while ($stmt->fetch()){
			$html .= '<div><a href="fullimage.php?id=' .$id .'"><img src="thumbnails/'. $thumbnail .'"></a>'. $clickCount. ' click(s)</div>';
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
	
?>