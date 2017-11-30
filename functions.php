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
		$stmt = $mysqli->prepare("SELECT filename, thumbnail FROM pildid");
		$stmt->bind_result($filename, $thumbnail);
		$stmt->execute();
		//kõik pisipildid
		while ($stmt->fetch()){
			$html .= '<a href="#"><img src="thumbnails/'. $thumbnail .'"></a>';
		}
		
		$stmt->close();
		$mysqli->close();
		echo $html;
	}
	
	
?>