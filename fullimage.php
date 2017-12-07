<?php
$id = ($_GET["id"]);
$notice = "";


	require("../../config.php");
	require("functions.php");
	$database = "if17_mihkel_2";
	$photo_dir = "uploads/";
	$thumb_dir = "thumbnails/";
	
		onImageClick($id);
		
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

	function listIdeas(){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, comment, name, created FROM kommentaarid WHERE pic_id = ? ORDER BY id DESC");
		echo $mysqli->error;
		$stmt->bind_param("i", $id);
		$stmt->bind_result($commid, $comm, $commName, $date);
		$stmt->execute();
		while($stmt->fetch()){
			$notice .= '<p>' .$date .' | ' .$commName.' | '.$comm .'</p>';
		}
		$stmt->close();
		$mysqli->close();
		return $notice;
	}

	if(isset($_POST["commentButton"])){
		header("Location: ?id=" .$_POST["id"]);
		exit();
		if(isset($_POST["comment"]) and !empty($_POST["comment"])){
			$comment = $_POST["comment"];
			$commName = $_POST["commName"];
			$id = $_POST["id"];
			saveIdea($comment, $commName, $id);
		}
	}

	function saveIdea($comment, $user, $id){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO kommentaarid (comment, name, pic_id) VALUES (?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("ssi", $comment, $user, $id);
		if($stmt->execute()){
			$notice = "Kommentaar on salvestatud!";
		} else {
			$notice = "Salvestamisel tekkis viga: " .$stmt->error;
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" ></meta>
		<title></title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<header>
			<div class="header-left">mingi logo siia nt</div>
			<div class="header-right"><a href="upload.php">Upload!</a></div>
		</header>
		<br>
		<br>
		<br>
		<?php echo $html; ?>
	<h1>Lisa kommentaar</h1>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<input name="id" type="hidden" value="<?php echo $_GET["id"]; ?>">
		<label>Nimi: </label>
		<input name="commName" type="text">
		<br>
		<label>Kommentaar: </label>
		<input name="comment" type="text">
		<br>
		<input name="commentButton" type="submit" value="OK">
	<?php echo listIdeas(); ?>
	</body>
</html>