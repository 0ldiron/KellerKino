<!DOCTYPE html>
<html>
<head>
	<title>Kellerkino</title>
	<meta content="EN" http-equiv="Content-Language"></meta>
	<link type="text/css" rel="stylesheet" href="css/core.css?1.3.57"></link>
	<link type="text/css" rel="stylesheet" href="css/kellerkino.css?1.3.57"></link>
	<link type="text/css" media="only screen and (max-device-width: 1024px)" rel="stylesheet" href="css/ipad.css?1.0.5"></link>
	
	<meta http-equiv="content-type" content="text/html; charset=utf-8"> 
	<!-- HTML 4.x --> 
	<meta charset="utf-8"> 
	<!-- HTML5 -->
	<script src="js/my_jquery.min.js"></script>
	<script src="js/kellerkino.js"></script>
</head>
<body>
    <div id="header">
		<div id="navigation">
		<ul>
			<li>Video Wishlist</li>
		</ul>
		</div>
	</div>

	<div id="content">
	<?php

		include("SubVideo.php");

		PrintVideos('SELECT * FROM movies WHERE status=1 ORDER BY lfdnr DESC', 0);
		
	?>

	</div> 
</body>
</html>