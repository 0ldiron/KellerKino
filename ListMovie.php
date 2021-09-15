<?php
session_start();
include "Settings.php";

$sql_stmt = false;
$row_count = 0;
$first = true;

function Rating_32($rating, $votes)
{
	$arr_bgc = array("#63BE7B","#85C87D","#A8D27F","#CBDC81","#EDE683","#FFDD82","#FDC07C","#FCA377","#FA8671","#F8696B");
	$txt_vot = number_format($votes,0,",",".");
    
    print "<div class=\"cRating\">";
	print "  <img src=\"images/rating.png\" class=\"cRatingIcon\" title=\"$txt_vot\" style=\"background-color: ".$arr_bgc[round($rating)].";\">\n";
	print "  <div title=\"$txt_vot\" class=\"cRatingText\">".number_format($rating,1,",",".")."</div>\n";
	print "</div>\n";
}

if (isset($_POST['idGenre']))
{
	$sql_stmt = 'SELECT * FROM movie_view JOIN genre_link ON genre_link.media_id = movie_view.idMovie WHERE genre_link.genre_id='.$_POST['idGenre'].' ORDER BY c02 LIMIT '.$SQL_LIMIT.' OFFSET 0';
}
elseif (isset($_POST['idTag']))
{
	$sql_stmt = 'SELECT * FROM movie_view JOIN tag_link ON tag_link.media_id = movie_view.idMovie WHERE tag_link.tag_id='.$_POST['idTag'].' ORDER BY c02 LIMIT '.$SQL_LIMIT.' OFFSET 0';
}
elseif (isset($_POST['cXTitle']))
{
	$sql_stmt = 'SELECT * FROM movie_view WHERE c02 LIKE \''.$_POST['cXTitle'].'%\' ORDER BY c02 LIMIT '.$SQL_LIMIT.' OFFSET 0';
}
elseif (isset($_POST['idRating']))
{
	$sql_stmt = 'SELECT * FROM movie_view WHERE rating LIKE \''.$_POST['idRating'].'%\' ORDER BY c02 LIMIT '.$SQL_LIMIT.' OFFSET 0';
}
elseif (isset($_POST['idMovie']))
{
	$sql_stmt = 'SELECT * FROM movie_view WHERE idMovie IN ('.$_POST['idMovie'].') ORDER BY c02 LIMIT '.$SQL_LIMIT.' OFFSET 0';
}
elseif (isset($_POST['cXDate']) && (strcasecmp($_POST['cXDate'],'Played') == 0))
{
	$sql_stmt = 'SELECT * FROM movie_view ORDER BY lastPlayed DESC LIMIT '.$SQL_LIMIT.' OFFSET 0';
}
elseif (isset($_POST['cXDate']) && (strcasecmp($_POST['cXDate'],'Added') == 0))
{
	$sql_stmt = 'SELECT * FROM movie_view ORDER BY dateAdded DESC LIMIT '.$SQL_LIMIT.' OFFSET 0';
}
elseif (isset($_POST['next']))
{
	$arr = explode(' ', $_SESSION['SQL_STMT']);
	for ($i=0; $i<count($arr); $i++)
	{
		if (0 == strcasecmp($arr[$i], 'LIMIT'))
		{
			$LIMIT = $arr[$i+1];
		}
		if (0 == strcasecmp($arr[$i], 'OFFSET'))
		{
			$arr[$i+1] += $LIMIT;
		}
	}
	$sql_stmt = implode(' ', $arr);
	$first = false;
}
$_SESSION['SQL_STMT'] = $sql_stmt;

#DEBUG#
print '<script>console.log("'.$sql_stmt.'")</script>';

if ($sql_stmt)
{
	$db = new SQLite3($SQL_MOVIE);
	$res = $db->query($sql_stmt);
	
	if ($first) print '<div id="movieLibraryContainer" class="contentContainer">';
	while($row = $res->fetchArray(SQLITE3_ASSOC))
	{
		$row_count++;
		$title = $row['c00'];
		if (strlen($title) > 26)
		{
			$title = substr($title, 0, 23)."...";
		}
		
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
		}

		if ($row['lastPlayed']) print '<div class="divTST cPlayed">';
		else print '<div class="divTST">';
		$cover = str_replace('/w500/','/w185/',$cover);
		
		print '<div class="moviePoster" data-id="'.$row['idMovie'].'">';
		
		print "<img class=\"cover\" alt=\"".$title."\" src=".$cover.">";
#		if ($row['lastPlayed']) print '<div class="movieIcon"><img class="cInfo" src="images/status_2.png" title="'.$row['lastPlayed'].'"></div>';

		print '<div class="movieIcon">';
		Rating_32($row['rating'], $row['votes']);
		if (stripos($row['strFileName'], "3D" ))
		{
			print '<img class="cInfo" src="images/3D.png">';
		}
		if ($row['lastPlayed']) print '<img class="cInfo" src="images/status_2.png" title="'.$row['lastPlayed'].'">';
		print '</div>';

		print '<div class="desc">'.$title.'</div>';

		print '</div>'; # moviePoster
		
		print '<div class="movieDetail">';
#		echo '<B>'.$row['c00'].' ('.$row['c07'].')</B>';
		echo '<B>'.$row['c00'].' ('.substr($row['premiered'],0,4).')</B>';
		echo '<TABLE>';
#		echo '<TR><TD>Rating:</TD><TD>'.substr($row['c05'],0,3).'</TD></TR>';	# imdbRating
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
		print '</div>'; # movieDetail
		print '</div>'; # divTST
	} 
	if ($row_count == $SQL_LIMIT)
	{
		echo '<div class="divTST" id="nextMovie">';
		echo '<img class="cover" src="images/nextVideo.png" height="278" width="185">';
		echo '</div>';
	}
	if ($first) print "</div>"; # contentContainer
	$db->close();
}
?>