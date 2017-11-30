<?php
	require("../../config.php");
	require("photoupload.class.php");
	$database = "if17_mihkel_2";
	$photo_dir = "uploads/";
	$thumb_dir = "thumbnails/";
	$notice = "";
//Algab foto laadimise osa
	$target_dir = "uploads/";
	$thumbs_dir = "thumbnails/";
	$target_file = "";
	$thumb_file = "";
	$uploadOk = 1;
	$imageFileType = "";
	$maxWidth = 600;
	$thumbsize = 100;
	$maxHeight = 400;
	$marginVer = 10;
	$marginHor = 10;
	
	//Kas vajutati üleslaadimise nuppu
	if(isset($_POST["submit"])) {
		
		if(!empty($_FILES["fileToUpload"]["name"])){
			
			//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]))["extension"]);
			$timeStamp = microtime(1) *10000;
			//$target_file = $target_dir . pathinfo(basename($_FILES["fileToUpload"]["name"]))["filename"] ."_" .$timeStamp ."." .$imageFileType;
			$target_file = "rt_" .$timeStamp ."." .$imageFileType;
			$thumb_file = "rt_" .$timeStamp .".jpg";
		
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				$notice .= "Fail on pilt - " . $check["mime"] . ". ";
				$uploadOk = 1;
			} else {
				$notice .= "See pole pildifail. ";
				$uploadOk = 0;
			}
		
			//Kas selline pilt on juba üles laetud
			if (file_exists($target_file)) {
				$notice .= "Kahjuks on selle nimega pilt juba olemas. ";
				$uploadOk = 0;
			}
			//Piirame faili suuruse
			/*if ($_FILES["fileToUpload"]["size"] > 1000000) {
				$notice .= "Pilt on liiga suur! ";
				$uploadOk = 0;
			}*/
			
			//Piirame failitüüpe
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				$notice .= "Vabandust, vaid jpg, jpeg, png ja gif failid on lubatud! ";
				$uploadOk = 0;
			}
			
			//Kas saab laadida?
			if ($uploadOk == 0) {
				$notice .= "Vabandust, pilti ei laetud üles! ";
			//Kui saab üles laadida
			} else {		
								
				//kasutame klassi
				$myPhoto = new Photoupload($_FILES["fileToUpload"]["tmp_name"], $imageFileType);
				$myPhoto->readExif();
				$myPhoto->resizeImage($maxWidth, $maxHeight);
				$myPhoto->addWatermark($marginHor, $marginVer);
				//$myPhoto->addTextWatermark($myPhoto->exifToImage);
				$myPhoto->addTextWatermark("Heade mõtete veeb");
				$notice .= $myPhoto->savePhoto($target_dir, $target_file);
				//$myPhoto->saveOriginal(kataloog, failinimi);
				$notice .= $myPhoto->createThumbnail($thumbs_dir, $thumb_file, $thumbsize, $thumbsize);
				$myPhoto->clearImages();
				unset($myPhoto);
				
				//lisame andmebaasi
				if(isset($_POST["altText"]) and !empty($_POST["altText"])){
					$alt = $_POST["altText"];
				} else {
					$alt = "Foto";
				}
				addPhotoData($target_file, $thumb_file);
				
			}
		
		} else {
			$notice = "Palun valige kõigepealt pildifail!";
		}//kas faili nimi on olemas lõppeb
	}//kas üles laadida lõppeb

	function addPhotoData($filename, $thumbname){
		//echo $GLOBALS["serverHost"];
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO pildid (filename, thumbnail) VALUES (?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("ss", $filename, $thumbname);
		//$stmt->execute();
		if ($stmt->execute()){
			$GLOBALS["notice"] .= "Foto andmete lisamine andmebaasi õnnestus! ";
		} else {
			$GLOBALS["notice"] .= "Foto andmete lisamine andmebaasi ebaõnnestus! ";
		}
		$stmt->close();
		$mysqli->close();
	}
	
	if(isset($_POST["submit"])){
		header("Location: index.php");
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>
	RYHMATOO
	</title>
</head>
<body>
	<h1>Pildi üleslaadimine</h1>
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<label>Valige pildifail:</label>
		<input type="file" name="fileToUpload" id="fileToUpload">
		<br>
		<br>
		<input type="submit" value="Lae üles" name="submit">
	</form>
	<span><?php echo $notice; ?></span>
</body>
</html>