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
			<div class="header-left">mingi logo siia nt</div>
			<div class="header-right"><a href="upload.php">Upload!</a></div>
		</header>
		<br>
		<br>
		<br>
		<div class="container">
			<div>
				<?php echo displayImages(); ?>
			</div>
		</div>
		
	</body>
</html>