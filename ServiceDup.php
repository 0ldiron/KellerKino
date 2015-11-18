<?php

include("SubVideo.php");

$db1 = new SQLite3('videoworld.sqlite');
$res1 = $db1->query('SELECT imdb_id,count(*) as x FROM movies GROUP BY imdb_id having x>1');
$doubles = '';
while($row1 = $res1->fetchArray(SQLITE3_ASSOC))
{
	if ($row1['x'] > 1)
	{
		if (!empty($row1['imdb_id']))
		{
			if (empty($doubles)) $doubles = '"'.$row1['imdb_id'].'"';
			else $doubles .= ',"'.$row1['imdb_id'].'"';
		}
	}
}
$db1->close();

if (!empty($doubles))
{
	$stmt = 'SELECT * FROM movies WHERE imdb_id IN ('.$doubles.') ORDER BY imdb_id';
	PrintVideos($stmt, 2);
}
?>