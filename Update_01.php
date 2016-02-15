<?php

include "SubIndex.php";

$db = new SQLite3('videoworld.sqlite');
$res = $db->query('SELECT id,title FROM movies');
$arr = array();

while($row2 = $res->fetchArray(SQLITE3_ASSOC))
{
	$arr[$row2['id']] = GetIndex($row2['title']);
}
foreach ($arr as $id => $str_c02)
{
	echo $str_c02;
	$stmt = $db->prepare('UPDATE movies SET idx_title=? WHERE id=?');
	$stmt->bindParam( 1, $str_c02);
	$stmt->bindParam( 2, $id);
	$rc = $stmt->execute();
}
$db->close();
?>