<?php
function Rating_32($rating, $votes)
{
	$arr_bgc = array("#63BE7B","#85C87D","#A8D27F","#CBDC81","#EDE683","#FFDD82","#FDC07C","#FCA377","#FA8671","#F8696B");
	$txt_vot = number_format($votes,0,",",".");
    
    print "<div class=\"cRating\">";
	print "  <img src=\"images/rating.png\" class=\"cRatingIcon\" title=\"$txt_vot\" style=\"background-color: ".$arr_bgc[round($rating)].";\">\n";
	print "  <div title=\"$txt_vot\" class=\"cRatingText\">".number_format($rating,1,",",".")."</div>\n";
	print "</div>\n";
}


# $mode 0: Keine Buttons
#       1: Status Buttons
#       2: Delete Button
#		3: Info Buttons
function PrintVideos($stmt, $mode, $first)
{
	$db = new SQLite3('videoworld.sqlite');
	$res = $db->query($stmt);
	$rows = 0;
	
	if ($first) echo '<div id="movieLibraryContainer" class="contentContainer">';
	while($row = $res->fetchArray(SQLITE3_ASSOC))
	{
		$rows++;
		$title = $row['title'];
		if (strlen($title) > 26)
		{
			$title = substr($title, 0, 23)."...";
		}
		
		echo '<div class="divTST">';

		echo '<div class="videoPoster" data-id="'.$row['lfdnr'].'">';
		if (empty($row['poster_path']))
		{
			echo '<img class="cover" src="images/nocover.png" height="278" width="185">';
		}
		else
		{
	#		$tmdb_V3->getImageURL("w185"): 	http://image.tmdb.org/t/p/w185
			echo '<img class="cover" alt="'.$title.'" src="http://image.tmdb.org/t/p/w185'.$row['poster_path'].'">';
		}

		echo '<div class="movieIcon">';
		Rating_32($row['imdbRating'],$row['imdbVotes']);
		if ($mode == 1)
		{
			$s1= ""; $s2= ""; $s3= "";
			switch ($row['status'])
			{
				case 1: $s1=" cActive"; break;
				case 2: $s2=" cActive"; break;
				case 3: $s3=" cActive"; break;
			}

			echo '<img class="cUpd" data-id="'.$row['lfdnr'].'" data-state="0" src="images/status_0.png">';
			echo '<img class="cUpd'.$s1.'" data-id="'.$row['lfdnr'].'" data-state="1" src="images/status_1.png">';
			echo '<img class="cUpd'.$s3.'" data-id="'.$row['lfdnr'].'" data-state="3" src="images/status_3.png">';
			echo '<img class="cUpd'.$s2.'" data-id="'.$row['lfdnr'].'" data-state="2" src="images/status_2.png">';
		}
		elseif ($mode == 2)
		{
			echo '<img class="cDel" data-id="'.$row['lfdnr'].'" data-state="0" src="images/delete.png">';
		}
		elseif ($mode == 3)
		{
			switch ($row['status'])
			{
				case 1: echo '<img class="cInfo" src="images/status_1.png">'; break;
				case 2: echo '<img class="cInfo" src="images/status_2.png">'; break;
				case 3: echo '<img class="cInfo" src="images/status_3.png">'; break;
			}
		}
		echo '</div>'; # movieIcon

		echo '<div class="desc">'.$title.'</div>';
		echo '</div>'; # videoPoster
		
		echo '<div class="movieDetail">';
		echo '<B>'.$row['title'].' ('.substr($row['release_date'],0,4).')</B>';
		echo '<TABLE>';
		echo '<TR><TD>Rating:</TD><TD>'.$row['imdbRating'].' ('.$row['imdbVotes'].')</TD></TR>';
		echo '<TR><TD>Genre:</TD><TD>'.$row['genres'].'</TD></TR>';
		echo '<TR><TD>Director:</TD><TD>'.$row['director'].'</TD></TR>';
		echo '<TR><TD>Actors:</TD><TD>'.$row['actors'].'</TD></TR>';
		echo '</TABLE>';
		echo $row['overview'];
		echo '</div>'; # movieDetail
		echo '</div>'; # divTST
	}

	if ($rows == 10)
	{
		echo '<div class="divTST" id="nextVideo">';
		echo '<img class="cover" src="images/nextVideo.png" height="278" width="185">';
		echo '</div>';
	}
		
	if ($first) echo "</div>"; #contentContainer

	$db->close();

	#DEBUG#
	echo '<script>console.log(\''.$stmt.'\')</script>';
}
?>
