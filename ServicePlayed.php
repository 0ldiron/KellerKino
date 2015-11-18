<head>
	<title>Kellerkino: Service</title>
	<meta content="EN" http-equiv="Content-Language"></meta>
	<link type="text/css" rel="stylesheet" href="css/core.css?1.3.57"></link>
	<link type="text/css" media="only screen and (max-device-width: 1024px)" rel="stylesheet" href="css/ipad.css?1.0.5"></link>
	
<meta http-equiv="content-type" content="text/html; charset=utf-8"> 
<!-- HTML 4.x --> 
<meta charset="utf-8"> 
<!-- HTML5 -->
<head>	
</head>

<body>
	<?php
	$db = new SQLite3('MyVideos93.db');
	$res = $db->query('SELECT * FROM files WHERE playCount >0 ORDER BY strFilename');
	while($row = $res->fetchArray(SQLITE3_ASSOC))
	{
		$title = $row['strFilename'];
		if (strcasecmp(substr($title, -4), '.mkv') == 0)
		{
			print 'UPDATE files SET playCount='.$row['playCount'].', lastPlayed="'.$row['lastPlayed'].'" WHERE strFilename="'.$title.'";';
			print "<BR>\n";
		}
	} 
	$db->close();
	?>
</body>
</html>


