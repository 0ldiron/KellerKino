<?php
include "Settings.php";

$ofs = $_POST["ofs"];
$found = 0;

$db1 = new SQLite3('videoworld.sqlite');
$db2 = new SQLite3($SQL_MOVIE);
$res2 = $db2->query('SELECT c00,c09 FROM movie LIMIT 10 OFFSET '.$ofs);
while($row2 = $res2->fetchArray(SQLITE3_ASSOC))
{
	$found = 1;
	if (!empty($row2['c09']))
	{
		$db1->exec('UPDATE movies SET status=2 WHERE status<>2 AND imdb_id="'.$row2['c09'].'"');
		if ($db1->changes())
		{
				echo $row2['c00'].'<BR>';
		}
	}
}
$db1->close();
$db2->close();

if ($found)
{
	$ofs = $ofs+10;
	echo '<script>$.post("'.$_SERVER['PHP_SELF'].'",{ofs:'.$ofs.'},AppendBody);document.title = "Wait('.$ofs.') ...";</script>';
} else
{
	echo '<script>document.title = "Ready!";</script>';
}
?>