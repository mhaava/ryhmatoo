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
		$stmt = $mysqli->prepare("SELECT id, filename, thumbnail FROM pildid");
		$stmt->bind_result($id, $filename, $thumbnail);
		$stmt->execute();
		//kõik pisipildid
		while ($stmt->fetch()){
			$html .= '<a href="fullimage.php?id=' .$id .'"><img src="thumbnails/'. $thumbnail .'"></a>';
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