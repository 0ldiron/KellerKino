<?php

include "SubIndex.php";

$ofs = $_POST["ofs"];
$found = 0;

$db = new SQLite3('MyVideos93.db');
$res = $db->query('SELECT idMovie,c00 FROM movie LIMIT 50 OFFSET '.$ofs);

$arr = array();

while($row2 = $res->fetchArray(SQLITE3_ASSOC))
{
	$found = 1;
	$arr[$row2['idMovie']] = GetIndex($row2['c00']);
}
foreach ($arr as $idMovie => $str_c02)
{
	echo $str_c02.'<BR>';
	$stmt = $db->prepare('UPDATE movie SET c02=? WHERE idMovie=?');
	$stmt->bindParam( 1, $str_c02);
	$stmt->bindParam( 2, $idMovie);
	$rc = $stmt->execute();
}
$db->close();

if ($found)
{
	$ofs = $ofs+50;
	echo "<script>\$.post('{$_SERVER['PHP_SELF']}',{ofs:$ofs},AppendBody);document.title = 'Wait($ofs) ...';</script>";
} else
{
	echo '<script>document.title = "Ready!";</script>';
}

?>