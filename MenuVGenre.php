<?php
	$db = new SQLite3('videoworld.sqlite');
	$res = $db->query('SELECT DISTINCT genres FROM movies WHERE genres<>""');
	$genres = array();
	while($row = $res->fetchArray(SQLITE3_ASSOC))
	{
		$genres = array_unique(array_merge($genres, explode( ' | ', $row['genres'])));
	}
	$db->close();
	
	echo '<div id="navigation">';
	echo '<ul>';
	foreach ($genres as $value)
	{
		echo '<li class="cVGenre">'.$value.'</li>'."\n\r";
	}
	echo '</ul>';
	echo '</div>';
?>