<?php
include "Settings.php";
include("SubVideo.php");

$db1 = new SQLite3('videoworld.sqlite');
$db2 = new SQLite3($SQL_MOVIE);
$res2 = $db2->query('SELECT uniqueid_value FROM movie_view');
$updates = '';
while($row2 = $res2->fetchArray(SQLITE3_ASSOC))
{
	if (!empty($row2['uniqueid_value']))
	{
		$db1->exec('UPDATE movies SET status=2 WHERE status<>2 AND imdb_id="'.$row2['uniqueid_value'].'"');
		if ($db1->changes())
		{
			if (empty($updates)) $updates = '"'.$row2['uniqueid_value'].'"';
			else $updates .= ',"'.$row2['uniqueid_value'].'"';
		}
	}
}
$db1->close();
$db2->close();

if (!empty($updates))
{
	$stmt = 'SELECT * FROM movies WHERE imdb_id IN ('.$updates.') ORDER BY title';
	PrintVideos($stmt, 0, true);
}
?>