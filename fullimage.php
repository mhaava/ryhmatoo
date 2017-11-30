<?php
$id = ($_GET["id"]);


	require("../../config.php");
	$database = "if17_mihkel_2";
	$photo_dir = "uploads/";
	$thumb_dir = "thumbnails/";
	
	//muuta hiljem muutujad vastavaks
		$html = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT filename FROM pildid WHERE id=?");
		$stmt->bind_param("i", $id);
		$stmt->bind_result($filename);
		$stmt->execute();
		//kõik pisipildid
		while ($stmt->fetch()){
			$html .= '<img src="uploads/'. $filename .'">';
		}
		
		$stmt->close();
		$mysqli->close();
		echo $html;
	
?>