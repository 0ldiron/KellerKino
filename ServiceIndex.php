<?php

include "SubIndex.php";

$db = new SQLite3('MyVideos93.db');
$res = $db->query('SELECT idMovie,c00 FROM movie');
$arr = array();

while($row2 = $res->fetchArray(SQLITE3_ASSOC))
{
	$arr[$row2['idMovie']] = GetIndex($row2['c00']);
}
foreach ($arr as $idMovie => $str_c02)
{
	echo $str_c02;
	$stmt = $db->prepare('UPDATE movie SET c02=? WHERE idMovie=?');
	$stmt->bindParam( 1, $str_c02);
	$stmt->bindParam( 2, $idMovie);
	$rc = $stmt->execute();
//	if ($db->changes())
//	{
		// if (empty($updates)) $updates = '"'.$row2['c09'].'"';
		// else $updates .= ',"'.$row2['c09'].'"';
	// }
}
$db->close();
?>