<?php

include("omdb_v1.php");

$omdb_V1 = new OMDBv1();

$ofs = $_POST["ofs"];
$found = 0;

$db1 = new SQLite3('videoworld.sqlite');
$res1 = $db1->query('SELECT imdb_id,imdbRating,imdbVotes FROM movies LIMIT 50 OFFSET '.$ofs);

while($row1 = $res1->fetchArray(SQLITE3_ASSOC))
{
	if (!empty($row1['imdb_id']))
	{
		$found = 1;
		$om_info = $omdb_V1->movieDetail($row1['imdb_id']);
		print 'UPDATE movies SET imdbRating="'.$om_info['imdbRating'].'", imdbVotes="'.$om_info['imdbVotes'].'" WHERE imdb_id="'.$row1['imdb_id'].'";';
		print "<BR>\n";
	}
}
$db1->close();

if ($found)
{
	$ofs = $ofs+50;
	echo '<script>$.post("ServiceRating.php",{ofs:'.$ofs.'},AppendBody);document.title = "'.$ofs.' Records";</script>';
} else
{
	echo '<script>document.title = "Ready!";</script>';
}


?>