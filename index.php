<?php
require ("functions.php");

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
			<div class="header-left"><img src="graphics/pealehelogo.png" alt="Logo" height="42" ></div>
			<div class="header-right"><a href="upload.php">Photo upload!</a></div>
		</header>
		<br>
		<br>
		<br>
		<div class="container">
			<div class=content>
				<?php echo displayImages(); ?>
			</div>
		</div>
		
	</body>
</html>