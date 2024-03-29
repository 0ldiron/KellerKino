<?php
include "Settings.php";

if ($_POST['id'] <> '')
{
	$sql_stmt = 'SELECT * FROM movie_view WHERE idMovie='.$_POST['id'];

	#DEBUG#
	print '<script>console.log("'.$sql_stmt.'")</script>';

	$db = new SQLite3($SQL_MOVIE);
	$res = $db->query($sql_stmt);
	
	if ($row = $res->fetchArray(SQLITE3_ASSOC))
	{
#		$first = strpos($row['c08'],"preview=");
		$first = strpos($row['c08'],'aspect="poster" preview=');
		if ($first === false)
		{
			$cover = "images/DefaultVideo.png";
		}
		else
		{
#			$first+=8;
			$first+=24;
			$last  = strpos($row['c08'],">",$first);
			if ($last === false)
			{
				$cover = substr($row['c08'], $first);
			}
			else
			{
				$cover = substr($row['c08'], $first, $last-$first);
			}
			$cover = str_replace('/w500/','/w300/',$cover);
		}

		echo "<TABLE><TR><TD>";
		echo "<img class=\"Bigcover\" title=\"".$row['c00']."\" src=".$cover.">";
		echo "</TD><TD>";

#		echo '<B>'.$row['c00'].' ('.$row['c07'].')</B>';
		echo '<B>'.$row['c00'].' ('.substr($row['premiered'],0,4).')</B>';
		echo ' <a title="Add to list" href="" onclick="AddFav('.$row['idMovie'].');return false;" style="font-family: \'icon-worksregular\';">&#34;</a>';
		echo '<TABLE>';
#		echo '<TR><TD>Rating:</TD><TD>'.substr($row['c05'],0,3).' ('.$row['c04'].')</TD></TR>';	# imdbRating
		echo '<TR><TD>Rating:</TD><TD>'.substr($row['rating'],0,3).' ('.number_format($row['votes']).')</TD></TR>';	# imdbRating
		echo '<TR><TD>Genre:</TD><TD>'.$row['c14'].'</TD></TR>';	# genres
		echo '<TR><TD>Director:</TD><TD>'.$row['c15'].'</TD></TR>';
		$str_actors = '';
		$sql_stmt = 'SELECT name FROM actor JOIN actor_link ON actor.actor_id = actor_link.actor_id WHERE actor_link.media_id = '.$row['idMovie'].' ORDER BY actor_link.cast_order LIMIT 4';
		$res2 = $db->query($sql_stmt);
		while($row2 = $res2->fetchArray(SQLITE3_ASSOC))
		{
			if (empty($str_actors)) $str_actors = $row2['name'];
			else $str_actors .= ', '.$row2['name'];
		}
		echo '<TR><TD>Actors:</TD><TD>'.$str_actors.'</TD></TR>';
		echo '</TABLE>';
		echo $row['c01'];	#	overview
		echo "</TD></TR></TABLE>";
	} 
	$db->close();
}
?>