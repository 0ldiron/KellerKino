<?php

$db = new SQLite3('MyVideos93.db');
$res = $db->query('SELECT idMovie,c00 FROM movie');
$arr = array();

while($row2 = $res->fetchArray(SQLITE3_ASSOC))
{
	$str_c02 = utf8_decode($row2['c00']);
	$str_c02 = strtr ($str_c02, 'ƒд÷ц№ья', 'AaOoUuS');
	$str_c02 = strtoupper($str_c02);
	
	$worte=explode(" ",$str_c02);
	if ((strcasecmp($worte[0], "ein" ) == 0) ||
	   (strcasecmp($worte[0], "eine") == 0) ||
	   (strcasecmp($worte[0], "der" ) == 0) ||
	   (strcasecmp($worte[0], "die" ) == 0) ||
	   (strcasecmp($worte[0], "das" ) == 0) ||
	   (strcasecmp($worte[0], "the" ) == 0) ||
	   (strcasecmp($worte[0], "a"   ) == 0) ||
	   (strcasecmp($worte[0], "an"  ) == 0) ||
	   (strcasecmp($worte[0], "el"  ) == 0) ||
	   (strcasecmp($worte[0], "la"  ) == 0))
	{
		array_shift($worte); // erstes Wort wech
	}
	$c1 = substr($worte[0],0,1);
	if (ctype_digit($c1)) array_unshift($worte, '#');
	elseif (ctype_alpha($c1)) array_unshift ($worte, $c1);
	else array_unshift($worte, '*');
	$str_c02 = implode(" ",$worte);
	echo $str_c02,'<BR>';
	$arr[$row2['idMovie']] = $str_c02;
}
foreach ($arr as $idMovie => $str_c02)
{
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